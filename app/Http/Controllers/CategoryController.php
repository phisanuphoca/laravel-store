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
