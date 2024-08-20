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
        Schema::create('genre_post_relations', function (Blueprint $table) {
            # Columns
            $table->id();
            $table->unsignedBigInteger('genre_id');
            $table->unsignedBigInteger('post_id');
            $table->timestamps();

            # Foreign Keys
            $table->foreign('genre_id')->references('id')
            ->on('genres')->cascadeOnDelete();
            
            $table->foreign('post_id')->references('id')
            ->on('posts')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genre_post_relations');
    }
};
