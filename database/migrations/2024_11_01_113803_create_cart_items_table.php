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
        // Schema::create('cart_items', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->foreignId('cart_id')->constrained()->onDelete('cascade'); // Liên kết với cart
        //     $table->foreignId('product_id')->constrained();
        //     $table->foreignId('color_id')->constrained();
        //     $table->foreignId('size_id')->constrained();
        //     $table->integer('quantity');
        //     $table->decimal('price', 8, 2);
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
