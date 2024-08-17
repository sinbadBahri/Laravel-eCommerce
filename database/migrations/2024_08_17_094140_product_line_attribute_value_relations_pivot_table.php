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
        Schema::create('product_line_attr_values', function (Blueprint $table) {
            # Columns
            $table->id();
            $table->unsignedBiginteger('product_line_id');
            $table->unsignedBiginteger('attribute_value_id');
            $table->timestamps();


            # Foreign Keys
            $table->foreign('product_line_id')->references('id')
                 ->on('product_lines')->onDelete('cascade');

            $table->foreign('attribute_value_id')->references('id')
                ->on('attribute_values')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_line_attribute_value_relations');
    }
};