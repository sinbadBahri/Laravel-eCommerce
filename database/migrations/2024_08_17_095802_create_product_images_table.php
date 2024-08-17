<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            # Columns
            $table->id();
            $table->string('alternative_text');
            $table->string('mime_type');    # To store the mime type of the image
            $table->binary('image');    # To store the image as binary data
            $table->unsignedBiginteger('product_line_id');
            $table->timestamps();


            # Foreign Keys
            $table->foreign('product_line_id')->references('id')
                 ->on('product_lines')->onDelete('cascade');
        });

        # Alter the 'image' column to LONGBLOB
        DB::statement('ALTER TABLE product_images MODIFY image LONGBLOB');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
