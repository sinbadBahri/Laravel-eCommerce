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
        Schema::create('product_type_attribute_relations', function (Blueprint $table) {
            # Columns
            $table->id();
            $table->unsignedBiginteger('product_type_id');
            $table->unsignedBiginteger('attribute_id');
            $table->timestamps();


            # Foreign Keys
            $table->foreign('product_type_id')->references('id')
                 ->on('product_types')->onDelete('cascade');

            $table->foreign('attribute_id')->references('id')
                ->on('attributes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_type_attribute_relations_pivot');
    }
};
