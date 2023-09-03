<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
      'email' => $this->email,
      'address' => $this->address,
      'billing_address' => $this->billing_address,
      'summary_price' => $this->summary_price,
      'created_at' => $this->created_at->format(config('app.date_format')),
      'updated_at' => $this->updated_at->format(config('app.date_format')),
      'products' => ProductInOrderResource::collection($this->products)

    ];
  }
}
