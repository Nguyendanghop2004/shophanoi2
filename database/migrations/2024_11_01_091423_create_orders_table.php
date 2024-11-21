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
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Khóa ngoại đến bảng users
          
            $table->string('payment_method')->nullable(); // Phương thức thanh toán
            $table->decimal('total_price', 10, 2); // Tổng giá trị đơn hàng
            $table->string('address'); // Địa chỉ giao hàng
            $table->string('phone_number'); // Số điện thoại giao hàng
            $table->text('note')->nullable(); 
            $table->enum('status', ['chờ_xác_nhận', 'đã_xác_nhận', 'đang_giao_hàng', 'giao_hàng_thành_công', 'đã_hủy'])
                  ->default('chờ_xác_nhận'); // Trạng thái đơn hàng: chờ xác nhận, đã xác nhận, đang giao hàng, giao hàng thành công, đã hủy// Ghi chú
            $table->timestamps();
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
