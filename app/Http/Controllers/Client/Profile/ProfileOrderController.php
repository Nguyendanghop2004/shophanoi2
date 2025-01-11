<?php

namespace App\Http\Controllers\Client\Profile;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Order;
use App\Models\Province;
use App\Models\Wards;
use Auth;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProfileOrderController extends Controller
{



    public function showProfileOrder(string $id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $orderitems = $order->orderItems;
        $city = City::where('matp', $order->city_id)->first();
        $province = Province::where('maqh', $order->province_id)->first();
        $ward = Wards::where('xaid', $order->wards_id)->first();
        return view('client.user.profile.order-profile.index', compact('order', 'orderitems', 'city', 'province', 'ward'));
    }
}

