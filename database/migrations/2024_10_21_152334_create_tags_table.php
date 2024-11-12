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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Tên tag (Ví dụ: Best Sellers, New Arrivals, Review, Hướng dẫn)
            $table->string('type'); // Thêm cột type để phân biệt tag cho sản phẩm hoặc bài viết
            $table->string('description')->nullable(); // Mô tả tag
            $table->string('background_image')->nullable(); // Ảnh nền cho bộ sưu tập sản phẩm (nếu cần)
            $table->timestamps();
        });




    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
