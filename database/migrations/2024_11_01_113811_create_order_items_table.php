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
        // Schema::create('order_items', function (Blueprint $table) {
        //     $table->bigIncrements('id'); // ID của mục hóa đơn
        //     $table->unsignedBigInteger('order_id'); // ID hóa đơn (không ràng buộc foreign key)
        //     $table->unsignedBigInteger('variant_id'); // ID biến thể sản phẩm (không ràng buộc foreign key)
        //     $table->integer('quantity'); // Số lượng sản phẩm
        //     $table->decimal('price', 10, 2); // Giá tại thời điểm mua
        //     $table->timestamps(); // Thời gian tạo và cập nhật
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
