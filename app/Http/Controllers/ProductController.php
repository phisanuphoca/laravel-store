<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\ProductCollection;
use Illuminate\Support\Facades\Redis;

class ProductController extends Controller
{
  public function __construct()
  {
    $this->middleware('ability:admin,editor,viewer')->only('index', 'show');
    $this->middleware('ability:admin,editor')->only('store', 'update');
    $this->middleware('ability:admin')->only('destroy');
  }

  public function index()
  {
    $products = Product::paginate(10);
    return new ProductCollection($products);
  }

  public function show(Product $product)
  {
    $product->category;
    return response()->json([
      'success' => true,
      'data' => $product
    ]);
  }

  public function store()
  {
    return response()->json([
      'success' => true,
      'message' => "Your can access this function. This function is waiting to be implementation"
    ]);
  }

  public function update()
  {
    return response()->json([
      'success' => true,
      'message' => "Your can access this function. This function is waiting to be implementation"
    ]);
  }

  public function destroy()
  {
    return response()->json([
      'success' => true,
      'message' => "Your can access this function. This function is waiting to be implementation"
    ]);
  }

  public function list()
  {
    $value = Cache::tags(Product::class)->remember('products-page-' . request('page', 1), 86400, function () {
      return  Product::with(['category' => function ($query) {
        $query->select('id', 'name');
      }])->paginate(10);
    });
    return new ProductCollection($value);
  }
}
