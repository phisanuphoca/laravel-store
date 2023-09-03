<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\OrderResource;
use App\Http\Requests\CreateOrderRequest;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
  public function store(CreateOrderRequest $orderData)
  {

    DB::beginTransaction();
    $user = Auth::user();
    $products = $orderData->products;
    $order = null;
    try {
      $sum = 0;
      $productAttach = [];
      foreach ($products as $product) {
        $productUpdate = Product::find($product["id"]);
        $productUpdate->decrement("quantity", $product["quantity"]);
        $productUpdate->save();
        $sum += ($productUpdate->price * $product["quantity"]);

        $productAttach[$product["id"]] =
          [
            'summary_price' => $productUpdate->price * $product["quantity"],
            'quantity' => $product["quantity"]
          ];
      }
      $orderData['summary_price'] = $sum;
      $orderData['user_id'] = $user->id;
      //return $productAttach;
      $order = Order::create($orderData->only(
        'name',
        'email',
        'phone',
        'address',
        'billing_address',
        'summary_price',
        'user_id'
      ));


      $order->products()->attach($productAttach);
      DB::commit();

      return  $order;
    } catch (\Exception $e) {

      DB::rollback();
      return $e;
      return response()->json([
        'success' => false,
        'error' => 'Product out of stock',
      ]);
    }

    return response()->json([
      'success' => true,
      'order' => $order
    ]);
  }

  public function show(Order $order)
  {

    $order->products;
    $owner = $order->user()->select('id', 'name', 'email')->first();
    if ($owner->id != Auth::user()->id) {
      return response()->json([
        'success' => false,
        'error' => "can't access this data"
      ]);
    }
    return response()->json([
      'success' => true,
      'order' => new OrderResource($order),
      'owner' => $owner
    ]);
  }
}
