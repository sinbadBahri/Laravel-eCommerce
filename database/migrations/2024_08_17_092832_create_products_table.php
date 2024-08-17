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
        Schema::create('products', function (Blueprint $table) {
            # Columns
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('product_type_id');
            $table->timestamps();

            # Forein Keys
            $table->foreign('brand_id')->references('id')->on('brands')
            ->cascadeOnDelete();
            
            $table->foreign('product_type_id')->references('id')->on('product_types')
            ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
