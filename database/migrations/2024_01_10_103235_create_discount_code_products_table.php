<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountCodeProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('discount_code_products', function (Blueprint $table) {
            $table->id(); // Primary Key with AUTO_INCREMENT
            $table->unsignedBigInteger('discount_code_id'); // Foreign Key to discount_codes
            $table->unsignedBigInteger('product_id'); // Foreign Key to products

            // Indexes
            $table->index('discount_code_id');
            $table->index('product_id');

            // Foreign Keys
            $table->foreign('discount_code_id')
                ->references('id')
                ->on('discount_codes')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_code_products');
    }
}
