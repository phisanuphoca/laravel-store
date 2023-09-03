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

  public function show()
  {
    return "show";
  }

  public function store()
  {
    return "store";
  }

  public function update()
  {
    $product = Product::find(1);
    $product->name = request()->input('name');;
    $product->update();
    //if (!$user->roles()->find($data['role_id'])) {
    //  $user->roles()->attach($role);
    //}
    return  $product;
  }

  public function destroy()
  {
    return "destroy";
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
