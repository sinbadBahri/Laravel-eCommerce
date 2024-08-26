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
        Schema::create('discount_user_relations', function (Blueprint $table) {
            # Columns
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('discount_id');
            $table->timestamps();

            # Foreign Keys
            $table->foreign('user_id')->references('id')
            ->on('users')->cascadeOnDelete();

            $table->foreign('discount_id')->references('id')
            ->on('discounts')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_user_relations');
    }
};
