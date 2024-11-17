<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_tag_collection', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Liên kết với bảng products
            $table->foreignId('tag_collection_id')->constrained()->onDelete('cascade'); // Liên kết với bảng tag_collections
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_tag_collection');
    }
};
