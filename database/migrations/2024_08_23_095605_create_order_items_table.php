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
        Schema::create('order_items', function (Blueprint $table) {
            # Columns
            $table->id();
            $table->unsignedBigInteger('product_line_id');
            $table->unsignedBigInteger('order_id');
            $table->timestamps();

            # Foreign Keys
            $table->foreign('product_line_id')->references('id')
            ->on('product_lines')->cascadeOnDelete();

            $table->foreign('order_id')->references('id')
            ->on('orders')->cascadeOnDelete();
            
            # Number of each Product in a specific Cart
            $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
