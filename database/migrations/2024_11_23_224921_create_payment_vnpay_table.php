<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentVnPayTable extends Migration
{
    public function up()
    {
        Schema::create('payment_vnpay', function (Blueprint $table) {
            $table->id();
            $table->string('vnp_TmnCode');
            $table->string('vnp_TxnRef');
            $table->string('vnp_OrderInfo');
            $table->string('vnp_OrderType');
            $table->decimal('vnp_Amount', 15, 2);
            $table->string('vnp_Locale');
            $table->string('vnp_BankCode')->nullable();
            $table->string('vnp_IpAddr');
            $table->string('vnp_SecureHash');
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_vnpay');
    }
}
