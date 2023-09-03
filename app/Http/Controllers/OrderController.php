<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Events\OrderCreated;
use Illuminate\Http\Request;
use App\Mail\NewOrderSendMail;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\OrderResource;
use App\Http\Requests\CreateOrderRequest;

class OrderController extends Controller
{
  public function store(CreateOrderRequest $orderData)
  {

    DB::beginTransaction();
    $customer = Auth::user();
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
      $orderData['user_id'] = $customer->id;
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

      //$admin = User::where('email', $request->email)->first();
      $admin = User::whereHas(
        'roles',
        function ($q) {
          $q->where('slug', 'admin');
        }
      )->first();
      OrderCreated::dispatch($admin, $customer);
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
      ], 403);
    }
    return response()->json([
      'success' => true,
      'order' => new OrderResource($order),
      'owner' => $owner
    ]);
  }

  public function update(Order $order)
  {


    $mailData = [
      'title' => 'There is a new order',
      'body' => 'Please check the order from the customer.'
    ];

    Mail::to('phisanuphoca@gmail.com')->send(new NewOrderSendMail($mailData));
    dd('Success! Email has been sent successfully.');
  }
}
