<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $name = fake()->unique()->words($nb = 4, $asText = true);
    return [
      'name' => $name,
      'slug' => Str::slug($name),
      'short_description' => fake()->text(200),
      'description' => fake()->text(500),
      'price' => fake()->numberBetween(10, 1000),
      'is_in_stock' => true,
      'quantity' => fake()->numberBetween(10, 100),
      'image' => fake()->imageUrl(640, 480, 'product', true),
      'category_id' => fake()->numberBetween(1, 5)
    ];
  }
}
