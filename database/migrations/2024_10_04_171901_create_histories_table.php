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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Liên kết với sản phẩm chính
            $table->string('action'); // Hành động (update, create, delete)
            $table->string('model_type'); // Loại model (User, Post, v.v.)
            $table->foreignId('model_id'); // ID của model cần lưu lịch sử
            $table->json('changes'); // Lưu thông tin thay đổi dưới dạng JSON
            $table->timestamps(); // Lưu thời gian tạo bản ghi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
