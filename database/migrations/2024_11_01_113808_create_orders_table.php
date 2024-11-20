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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID hóa đơn
            $table->string('order_code')->unique(); // Mã đơn hàng (ví dụ: HN-random)
            $table->unsignedBigInteger('user_id')->nullable(); // ID người dùng (có thể null nếu là khách vãng lai)
            $table->string('name'); // Tên người đặt hàng
            $table->string('phone'); // Số điện thoại người đặt hàng
            $table->text('address'); // Địa chỉ giao hàng
            $table->string('email')->nullable(); // Email (không bắt buộc)
            $table->text('note')->nullable(); // Ghi chú
            $table->decimal('total', 10, 2); // Tổng giá trị hóa đơn
            $table->enum('status', ['chờ xác nhận', 'đã xác nhận', 'đang giao', 'đã hủy'])->default('chờ xác nhận'); // Trạng thái
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
