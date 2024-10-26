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
            $table->foreignId('product_variant_id')->constrained('product_variants')->onDelete('cascade'); // Liên kết với biến thể sản phẩm
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
