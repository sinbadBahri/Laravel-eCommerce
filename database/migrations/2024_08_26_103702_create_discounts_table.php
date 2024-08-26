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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('percentage')->check('percentage BETWEEN 1 AND 100');
            $table->boolean('have_code')->default(false); // Whether the discount requires a code
            $table->string('code')->nullable(); // Discount code, nullable if have_code is false
            $table->timestamp('valid_until')->nullable(); // Expiration date of the discount
            $table->unsignedBigInteger('max_amount')->nullable(); // Maximum discount amount
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
