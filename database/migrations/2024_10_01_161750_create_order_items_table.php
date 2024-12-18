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
      
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Khóa ngoại đến bảng orders
            $table->string('product_name');
            $table->string('image_url');
            $table->string('color_name'); // Tên màu sản phẩm
            $table->string('size_name'); // Tên kích thước sản phẩm
            $table->decimal('price', 10, 2); // Giá sản phẩm trong đơn hàng
            $table->integer('quantity'); // Số lượng sản phẩm trong đơn hàng
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
