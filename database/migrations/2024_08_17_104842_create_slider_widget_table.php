<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('slider_widgets', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);  # To turn the widget on or off
            $table->timestamps();
        });

        Schema::create('slider_widget_product_line', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('slider_widget_id');
            $table->unsignedBigInteger('product_line_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('slider_widget_id')->references('id')
            ->on('slider_widgets')->onDelete('cascade');

            $table->foreign('product_line_id')->references('id')
            ->on('product_lines')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('widget_product');
        Schema::dropIfExists('widgets');
    }

};
