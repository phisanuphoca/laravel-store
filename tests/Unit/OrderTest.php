<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;

class OrderTest extends TestCase
{
  /**
   * A basic unit test example.
   */
  public function test_create_order(): void
  {
    $category = Category::factory()->create();
    $product1 = Product::factory()->make();
    $product1['category_id'] = $category->id;
    $product1->save();

    $product2 = Product::factory()->make();
    $product2['category_id'] = $category->id;
    $product2->save();

    $user = User::factory()->create();

    $order = Order::create([
      'name' => 'tester',
      'email' => 'tester@example.com',
      'phone' => '0988888888',
      'address' => 'address',
      'billing_address' => 'billing_address',
      'summary_price' => 259.99,
      'user_id' => $user->id,
    ]);



    $order->products()->attach([
      $product1->id => [
        'summary_price' => $product1->price * 1,
        'quantity' => 1
      ],
      $product2->id => [
        'summary_price' => $product1->price * 1,
        'quantity' => 1
      ]
    ]);

    $this->assertDatabaseHas('product_orders', [
      'order_id' => $order->id,
      'product_id' => $product1->id,
    ]);
    $this->assertDatabaseHas('product_orders', [
      'order_id' => $order->id,
      'product_id' => $product2->id,
    ]);


    $order->delete();
    $product1->delete();
    $product2->delete();
    $category->delete();
    $user->delete();
  }
}
