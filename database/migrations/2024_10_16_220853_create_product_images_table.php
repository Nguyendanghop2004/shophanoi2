<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductImagesTable extends Migration
{
    public function up()
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Liên kết với sản phẩm chính
            $table->foreignId('color_id')->constrained('colors')->onDelete('cascade'); // Liên kết với màu
            $table->string('image_url');
            $table->timestamps();
            $table->softDeletes(); // Xóa mềm cho hình ảnh
        });


    }

    public function down()
    {
        Schema::dropIfExists('product_images');
    }
}
