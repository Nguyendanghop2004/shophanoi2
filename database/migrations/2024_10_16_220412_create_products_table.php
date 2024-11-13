<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('product_name');
            $table->string('sku')->unique();
            $table->decimal('price', 10, 2); // Giá của biến thể sản phẩm
            $table->tinyInteger('status')->default(1);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}