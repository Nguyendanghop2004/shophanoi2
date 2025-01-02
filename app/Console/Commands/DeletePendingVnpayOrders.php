<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Order;

class DeletePendingVnpayOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:delete-vnpay-pending';  // Đổi tên lệnh cho đúng chuẩn

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete VNPAY pending orders after 2 minutes';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Lấy tất cả các đơn hàng có phương thức thanh toán là VNPAY và trạng thái là 'Chờ thanh toán'
        $orders = Order::where('payment_method', 'vnpay')  // Kiểm tra phương thức thanh toán
            ->where('payment_status', 'chờ thanh toán')    // Kiểm tra trạng thái là "Chờ thanh toán"
            ->where('created_at', '<', Carbon::now()->subMinutes(2))  // Kiểm tra nếu đơn hàng đã tạo quá 2 phút
            ->get();

        foreach ($orders as $order) {
            // Xóa đơn hàng
            $order->delete();
            $this->info("Đơn hàng ID {$order->id} đã bị xóa vì chờ thanh toán quá 2 phút.");
        }
    }
}
