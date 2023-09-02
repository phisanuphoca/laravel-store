<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  public function index()
  {
    $user = Auth::user();
    return response()->json([
      'isAdmin' => $user->tokenCan('admin')
    ]);
  }
}
