<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
  /**
   * Transform the resource collection into an array.
   *
   * @return array<int|string, mixed>
   */
  public function toArray(Request $request): array
  {
    //return parent::toArray($request);
    return [
      'data' => $this->collection->map(function ($each) {
        return $each->only('name', 'slug', 'short_description', 'price', 'is_in_stock', 'image', 'category', 'created_at');
      }),
    ];
  }
}
