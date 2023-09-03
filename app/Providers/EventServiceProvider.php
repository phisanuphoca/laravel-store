<?php

namespace App\Providers;

use App\Models\Product;
use App\Events\OrderCreated;
use App\Observers\ProductObserver;
use App\Listeners\SendNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
  /**
   * The event to listener mappings for the application.
   *
   * @var array<class-string, array<int, class-string>>
   */
  protected $listen = [
    Registered::class => [
      SendEmailVerificationNotification::class,
    ],
    OrderCreated::class => [
      SendNotification::class,
    ]
  ];

  /**
   * Register any events for your application.
   */
  public function boot(): void
  {
    Product::observe(ProductObserver::class);
  }

  /**
   * Determine if events and listeners should be automatically discovered.
   */
  public function shouldDiscoverEvents(): bool
  {
    return false;
  }
}
