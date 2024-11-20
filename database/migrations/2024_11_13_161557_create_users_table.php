<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('users', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('email')->unique();
        //     $table->string('password');
        //     $table->string('image')->nullable();
        //     $table->string('address')->nullable();
        //     $table->string('phone_number')->nullable();
        //     $table->unsignedBigInteger('city_id')->nullable();
        //     $table->unsignedBigInteger('province_id')->nullable();
        //     $table->unsignedBigInteger('wards_id')->nullable();
        //     $table->timestamp('email_verified_at')->nullable();
        //     $table->string('status')->default('active');
        //     $table->rememberToken();
        //     $table->timestamps();
        //     $table->softDeletes(); // Thêm cột soft delete

        //     // Định nghĩa khóa ngoại
        //     $table->foreign('city_id')->references('matp')->on('cities')->onDelete('set null');
        //     $table->foreign('province_id')->references('maqh')->on('provinces')->onDelete('set null');
        //     $table->foreign('wards_id')->references('xaid')->on('wards')->onDelete('set null');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
