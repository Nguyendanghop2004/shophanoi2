<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShipperController extends Controller
{
    public function index()
    {
        // Lấy danh sách các Admin có vai trò 'Shipper'
        $admins = Admin::whereHas('roles', function ($query) {
            $query->where('name', 'Shipper');
        })->paginate(5);

        // Lọc các đơn hàng đã được giao cho shipper (đã có shipper assigned)
        $orders = Order::whereNotNull('assigned_shipper_id')->paginate(10);

        // Trả về view với dữ liệu shipper và đơn hàng
        return view('admin.shipper.index', compact('admins', 'orders'));
    }
}


