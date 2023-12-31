<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'slug',
    'short_description',
    'description',
    'price',
    'is_in_stock',
    'quantity',
    'image',
    'category_id',
  ];

  public function category()
  {
    return $this->belongsTo(Category::class);
  }
}
