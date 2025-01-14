<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountCodeUserLimitsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('discount_code_user_limits', function (Blueprint $table) {
            $table->id(); // id (AUTO_INCREMENT)
            $table->unsignedBigInteger('discount_code_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('usage_limit')->nullable();
            $table->integer('times_used')->default(0);

            // Timestamps
            $table->timestamps();

            // Indexes
            $table->index('discount_code_id');
            $table->index('user_id');

            // Foreign keys
            $table->foreign('discount_code_id')
                  ->references('id')
                  ->on('discount_codes')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_code_user_limits');
    }
}
