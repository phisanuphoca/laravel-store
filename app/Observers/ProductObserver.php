<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
  public function clearCache(): void
  {
    Cache::tags(Product::class)->flush();
  }
  /**
   * Handle the Product "created" event.
   */
  public function created(Product $product): void
  {
    $this->clearCache();
  }

  /**
   * Handle the Product "updated" event.
   */
  public function updated(Product $product): void
  {
    $this->clearCache();
  }

  /**
   * Handle the Product "deleted" event.
   */
  public function deleted(Product $product): void
  {
    $this->clearCache();
  }

  /**
   * Handle the Product "restored" event.
   */
  public function restored(Product $product): void
  {
    $this->clearCache();
  }

  /**
   * Handle the Product "force deleted" event.
   */
  public function forceDeleted(Product $product): void
  {
    $this->clearCache();
  }
}
