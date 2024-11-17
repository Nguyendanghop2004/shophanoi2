<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('city_id')->nullable()->after('phone_number');
            $table->unsignedInteger('province_id')->nullable()->after('city_id');
            $table->unsignedInteger('wards_id')->nullable()->after('province_id');

            $table->foreign('city_id')->references('matp')->on('tinhthanhpho')->onDelete('set null');
            $table->foreign('province_id')->references('maqh')->on('quanhuyen')->onDelete('set null');
            $table->foreign('wards_id')->references('xaid')->on('xaphuong')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropForeign(['province_id']);
            $table->dropForeign(['wards_id']);
            $table->dropColumn(['city_id', 'province_id', 'wards_id']);
        });
    }
}