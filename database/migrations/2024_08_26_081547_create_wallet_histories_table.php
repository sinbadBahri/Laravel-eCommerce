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
        Schema::create('wallet_histories', function (Blueprint $table) {
            # Columns
            $table->id();
            $table->unsignedBigInteger('wallet_id');
            $table->bigInteger('amount');
            $table->timestamps();

            # Foreign Key
            $table->foreign('wallet_id')->references('id')
            ->on('wallets')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_histories');
    }
};
