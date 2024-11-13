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
        Schema::create('tag_collections', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Tên của bộ sưu tập
            $table->string('description')->nullable(); // Mô tả của bộ sưu tập
            $table->tinyInteger('status')->default(1); // Trạng thái (1: Hoạt động, 0: Không hoạt động)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_collections');
    }
};
