<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('product_orders', function (Blueprint $table) {
      $table->id();
      $table->foreignId('product_id')->constrained()->cascadeOnDelete();
      $table->foreignId('order_id')->constrained()->cascadeOnDelete();
      $table->unique(['product_id', 'order_id']);
      $table->decimal('summary_price');
      $table->unsignedInteger('quantity')->default(10);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('product_orders');
  }
};
