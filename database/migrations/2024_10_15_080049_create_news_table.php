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
        Schema::create('news', function (Blueprint $table) {
            $table->id(); // Tạo cột id với kiểu bigint unsigned auto_increment
            $table->string('title'); // Tạo cột title với kiểu string
            $table->text('content'); // Tạo cột content với kiểu text
            $table->string('image_path'); // Tạo cột image_path với kiểu string
            $table->timestamp('published_at')->nullable(); // Tạo cột published_at với kiểu timestamp
            $table->bigInteger('category_id')->unsigned(); // Tạo cột category_id với kiểu bigint
            $table->bigInteger('product_id')->unsigned(); // Tạo cột product_id với kiểu bigint
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
