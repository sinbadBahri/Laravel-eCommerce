<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('product_widgets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('is_active')->default(true);  # To turn the widget on or off
            $table->timestamps();
        });

        Schema::create('product_widget_product_line', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_widget_id');
            $table->unsignedBigInteger('product_line_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('product_widget_id')->references('id')
            ->on('product_widgets')->onDelete('cascade');

            $table->foreign('product_line_id')->references('id')
            ->on('product_lines')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_widget_product_line');
        Schema::dropIfExists('product_widgets');
    }

};
