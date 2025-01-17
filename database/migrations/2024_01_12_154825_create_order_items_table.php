<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary Key
            $table->unsignedBigInteger('order_id'); // Foreign Key liên kết với orders
            $table->unsignedBigInteger('product_id'); // Foreign Key liên kết với products
            $table->unsignedBigInteger('color_id'); // Foreign Key liên kết với colors
            $table->unsignedBigInteger('size_id'); // Foreign Key liên kết với sizes
            $table->string('product_name', 255); // Tên sản phẩm
            $table->string('image_url', 255); // URL hình ảnh
            $table->string('color_name', 255); // Tên màu
            $table->string('size_name', 255); // Tên kích thước
            $table->decimal('price', 10, 2); // Giá sản phẩm
            $table->integer('quantity'); // Số lượng
            $table->timestamps(); // created_at & updated_at

            // Liên kết khóa ngoại
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade'); // Xóa bản ghi khi order bị xóa

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade'); // Xóa bản ghi khi product bị xóa

            $table->foreign('color_id')
                ->references('id')
                ->on('colors')
                ->onDelete('cascade'); // Xóa bản ghi khi color bị xóa

            $table->foreign('size_id')
                ->references('id')
                ->on('sizes')
                ->onDelete('cascade'); // Xóa bản ghi khi size bị xóa
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};