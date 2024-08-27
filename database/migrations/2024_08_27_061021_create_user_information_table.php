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
        Schema::create('user_information', function (Blueprint $table) {
            # Columns
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('lastName');
            $table->text('address');
            $table->timestamp('birthday')->nullable();
            $table->integer('countryId')->unsigned();
            $table->bigInteger('number')->unsigned();
            $table->bigInteger('zipCode')->unsigned();
            $table->timestamps();

            # Foreign Key
            $table->foreign('user_id')->references('id')
            ->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_information');
    }
};
