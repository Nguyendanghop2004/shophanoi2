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
<<<<<<< HEAD:database/migrations/2024_11_16_105618_create_category_product_table.php
        // Schema::create('category_product', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
        //     $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
        //     $table->timestamps();
        // });
=======
        Schema::create('blog_clients', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->string('title');
            $table->string('unique');
            $table->string('image');
            $table->string('slug')->unique();
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
>>>>>>> 33bdedcad09798685d94de0ca2f2571033411ade:database/migrations/2024_10_19_230728_create_blog_clients_table.php
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_clients');
    }
};
