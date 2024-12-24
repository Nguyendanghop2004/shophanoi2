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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->enum('type', ['collection', 'material']);  // Sử dụng enum để giới hạn các giá trị có thể có
            $table->string('description')->nullable();
            $table->string('background_image')->nullable();  // Nếu có ảnh nền, thì lưu đường dẫn
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
