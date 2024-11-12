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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id(); // Tạo khóa chính
            $table->string('title'); // Tiêu đề
            $table->string('short_description')->nullable(); // Mô tả ngắn, cho phép null
            $table->string('image_path'); // Đường dẫn ảnh
            $table->string('link_url')->nullable(); // Đường dẫn liên kết, cho phép null
            $table->integer('position')->nullable(); // Cho phép NULL
            $table->boolean('is_active')->default(true); // Trạng thái hoạt động
            $table->unsignedBigInteger('category_id'); // Khóa ngoại liên kết với bảng categories
            $table->timestamps(); // Tạo created_at và updated_at
            $table->softDeletes(); // Tạo cột deleted_at cho soft delete

            // Tạo khóa ngoại cho category_id
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            // Tạo ràng buộc UNIQUE cho category_id và position, nhưng cần chú ý rằng NULL không thể được áp dụng trong ràng buộc UNIQUE.
            $table->unique(['category_id', 'position'], 'category_position_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
