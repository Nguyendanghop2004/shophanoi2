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
        // Schema::table('orders', function (Blueprint $table) {
        //     $table->unsignedBigInteger('city_id')->after('address'); // Thêm trường city_id sau cột address
        //     $table->unsignedBigInteger('wards_id')->after('city_id'); // Thêm trường wards_id sau cột city_id
        //     $table->unsignedBigInteger('province_id')->after('wards_id'); // Thêm trường province_id sau cột wards_id
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('city_id');
            $table->dropColumn('wards_id');
            $table->dropColumn('province_id');
        });
    }
};
