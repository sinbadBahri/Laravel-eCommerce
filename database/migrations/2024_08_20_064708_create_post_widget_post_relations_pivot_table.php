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
        Schema::create('posts_widgets_relations', function (Blueprint $table) {
            # Columns
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('post_widget_id');
            $table->timestamps();

            # Foreign Keys
            $table->foreign('post_id')->references('id')
            ->on('posts')->cascadeOnDelete();
            
            $table->foreign('post_widget_id')->references('id')
            ->on('post_widgets')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts_widgets_relations');
    }
};
