<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductInOrderResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'slug' => $this->slug,
      'short_description' => $this->short_description,
      'price' => $this->price,
      'summary_price' => $this->pivot->summary_price,
      'quantity' => $this->pivot->quantity,
    ];
  }
}
