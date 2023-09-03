<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'email',
    'phone',
    'address',
    'billing_address',
    'summary_price',
  ];

  public function products()
  {
    return $this->belongsToMany(Product::class, 'product_orders')->withPivot('summary_price', 'quantity');
  }
}
