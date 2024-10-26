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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Liên kết với sản phẩm chính
            $table->foreignId('color_id')->constrained('colors')->onDelete('cascade'); // Liên kết với màu sắc
            $table->foreignId('size_id')->constrained('sizes')->onDelete('cascade'); // Liên kết với kích thước
            $table->string('product_code')->unique(); // Mã sản phẩm riêng cho từng biến thể
            $table->integer('stock_quantity')->default(0); // Số lượng tồn kho cho từng biến thể
            $table->decimal('price', 10, 2); // Giá của biến thể sản phẩm
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
