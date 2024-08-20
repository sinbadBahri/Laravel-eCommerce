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
        Schema::create('comments_widgets_relations', function (Blueprint $table) {
            # Columns
            $table->id();
            $table->unsignedBigInteger('comment_id');
            $table->unsignedBigInteger('comment_widget_id');
            $table->timestamps();

            # Foreign Keys
            $table->foreign('comment_id')->references('id')
            ->on('post_comments')->cascadeOnDelete();
            
            $table->foreign('comment_widget_id')->references('id')
            ->on('comment_widgets')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments_widgets_relations');
    }
};
