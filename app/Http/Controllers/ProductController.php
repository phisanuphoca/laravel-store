<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Auth;
use Illuminate\Http\Request;

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
    return "update";
  }

  public function destroy()
  {
    return "destroy";
  }
}