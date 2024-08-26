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
        Schema::table('product_lines', function (Blueprint $table) {
            $table->unsignedBigInteger('discount_id')->nullable();

            $table->foreign('discount_id')->references('id')
            ->on('discounts')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_lines', function (Blueprint $table) {
            //
        });
    }
};
