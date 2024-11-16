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
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id'); // ID sản phẩm
            $table->string('session_id'); // ID session của người dùng chưa đăng nhập
            $table->timestamps();

            // Unique constraint để tránh thêm sản phẩm nhiều lần vào wishlist của cùng session
            $table->unique(['product_id', 'session_id']);

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
