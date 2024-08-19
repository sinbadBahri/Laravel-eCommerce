<?php

use App\Models\Blog\Comment;
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
        Schema::create('post_comments', function (Blueprint $table) {
            # Columns
            $table->id();
            $table->text('content');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('parent_id');
            $table->timestamps();
            $table->softDeletes();
            
            # Foreign Keys
            $table->foreign('post_id')
                                ->references('id')
                                ->on('posts')
                                ->cascadeOnDelete();

            $table->foreign('user_id')
                                ->references('id')
                                ->on('users')
                                ->cascadeOnDelete();

            $table->foreign('parent_id')
                                ->nullable()
                                ->references('id')
                                ->on('post_comments')
                                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
