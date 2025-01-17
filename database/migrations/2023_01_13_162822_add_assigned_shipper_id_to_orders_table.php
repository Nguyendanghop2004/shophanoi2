<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssignedShipperIdToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('assigned_shipper_id')
                  ->nullable()
                  ->constrained('admins') // Liên kết với bảng admins
                  ->onDelete('set null'); // Đặt giá trị null nếu shipper bị xóa
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['assigned_shipper_id']); // Xóa ràng buộc khóa ngoại
            $table->dropColumn('assigned_shipper_id');   // Xóa cột
        });
    }
}
