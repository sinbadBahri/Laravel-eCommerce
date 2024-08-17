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
        Schema::create('category_images', function (Blueprint $table) {
            # Columns
            $table->id();
            $table->string('alternative_text');
            $table->string('mime_type');    # To store the mime type of the image
            $table->binary('image');    # To store the image as binary data
            $table->unsignedBiginteger('category_id');
            $table->timestamps();


            # Foreign Keys
            $table->foreign('category_id')->references('id')
                 ->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_images');
    }
};
