<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesalesTable extends Migration
{
    public function up()
    {
        Schema::create('pricesales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Liên kết với biến thể sản phẩm
            $table->decimal('sale_price', 10, 2); // Giá khuyến mãi cho biến thể
            $table->string('sku')->unique();
            $table->string('type');
            $table->timestamp('start_date'); // Ngày bắt đầu khuyến mãi
            $table->timestamp('end_date')->nullable(); // Ngày kết thúc khuyến mãi
            $table->timestamps();
            $table->softDeletes();
        });

    }

    public function down()
    {
        Schema::dropIfExists('pricesales');
    }
}
