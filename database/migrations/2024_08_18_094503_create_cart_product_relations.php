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
        Schema::create('cart_product_relations', function (Blueprint $table) {
            # Columns
            $table->id();
            $table->unsignedBiginteger('cart_id');
            $table->unsignedBiginteger('product_line_id');

            # Foreign Keys:
            $table->foreign('cart_id')->references('id')
                 ->on('carts')->onDelete('cascade');

            $table->foreign('product_line_id')->references('id')
                ->on('product_lines')->onDelete('cascade');
            
            # Number of each Product in a specific Cart
            $table->integer('quantity');
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_product_relations');
    }
};
