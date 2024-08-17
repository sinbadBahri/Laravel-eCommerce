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
        Schema::create('product_lines', function (Blueprint $table) {
            # Columns
            $table->id();
            $table->string('sku');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('price');
            $table->integer('stock_qty');
            $table->boolean('is_available');
            $table->timestamps();

            # Foreign Key
            $table->foreign('product_id')->references('id')->on('products')
            ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_lines');
    }
};
