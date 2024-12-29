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
        $admins = Admin::whereHas('roles', function ($query) {
            $query->where('name', 'Shipper');
        })->paginate(5);

        $orders = Order::whereNotNull('assigned_shipper_id')->paginate(10);

        return view('admin.shipper.index', compact('admins', 'orders'));
    }
}


