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
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Mã giảm giá
            $table->enum('discount_type', ['percentage', 'fixed']); // Loại giảm giá: phần trăm hoặc số tiền
            $table->decimal('discount_value', 10, 2); // Giá trị giảm giá
            $table->integer('min_quantity')->default(1); // Số lượng sản phẩm tối thiểu để áp dụng mã
            $table->decimal('min_total', 10, 2)->nullable(); // Giá trị đơn hàng tối thiểu để áp dụng mã
            $table->timestamp('start_date'); // Ngày bắt đầu của mã giảm giá
            $table->timestamp('end_date')->nullable(); 
            $table->integer('usage_limit')->default(1); // Số lần có thể sử dụng
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_codes');
    }
};
