<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  public function __construct()
  {
    $this->middleware('ability:admin,editor,viewer')->only('index', 'show');
    $this->middleware('ability:admin,editor')->only('store', 'update');
    $this->middleware('ability:admin')->only('destroy');
  }

  public function index()
  {
    $categories = Category::paginate(10);
    return new CategoryCollection($categories);
  }

  public function show(Category $category)
  {
    return response()->json([
      'success' => true,
      'data' => $category
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
}
