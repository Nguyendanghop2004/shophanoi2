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
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('name');
            $table->string('email');
            
            $table->string('payment_method')->nullable(); 
            
            
            $table->enum('payment_status', ['pending', 'paid', 'failed'])
                  ->default('pending');
            
          
            $table->decimal('total_price', 10, 2); 
            $table->string('address'); 
            $table->string('phone_number'); 
            $table->string('order_code'); 
            $table->text('note')->nullable(); 
            
           
            $table->enum('status', ['chờ_xác_nhận', 'đã_xác_nhận', 'đang_giao_hàng', 'giao_hàng_thành_công', 'đã_hủy'])
                  ->default('chờ_xác_nhận'); 
            
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
