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
            # Column
            $table->unsignedBigInteger('tax_id')->nullable();

            # Foreign Key
            $table->foreign('tax_id')->references('id')
            ->on('taxes')->cascadeOnDelete();
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
