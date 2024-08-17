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
        Schema::create('category_widgets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('is_active')->default(true);  # To turn the widget on or off
            $table->timestamps();
        });

        Schema::create('category_widget_category_relations', function (Blueprint $table) {
            # Columns
            $table->id();
            $table->unsignedBigInteger('category_widget_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            # Foreign keys
            $table->foreign('category_widget_id')->references('id')
            ->on('category_widgets')->onDelete('cascade');

            $table->foreign('category_id')->references('id')
            ->on('categories')->onDelete('cascade');

        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories_widgets_relating_tables');
    }
};
