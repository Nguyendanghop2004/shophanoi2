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
<<<<<<< HEAD
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
=======
        // Schema::create('blog_clients', function (Blueprint $table) {
        //     $table->id();
        //     $table->text('content');
        //     $table->string('title');
        //     $table->string('unique');
        //     $table->string('image');
        //     $table->string('slug')->unique();
        //     $table->boolean('status')->default(true);

        //     $table->timestamps();
        // });
>>>>>>> 5a6ee19b9729a054b484f6dd3f75ab8a2b83e543
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_clients');
    }
};
