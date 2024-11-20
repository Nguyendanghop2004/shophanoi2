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
        Schema::create('blog_clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable(); // Cột category_id có thể để trống
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->text('content');
            $table->string('title');
            $table->string('unique');
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_clients');
    }
};
