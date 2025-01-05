<?php

namespace App\Http\Controllers\Client\Profile;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Order;
use App\Models\Province;
use App\Models\Wards;
use Crypt;
use Illuminate\Http\Request;

class ProfileOrderController extends Controller
{
  
   public function ProfileOrder(String $id)  {
    
        // $id = Crypt::decryptString($encryptedId);

      
        // $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $order = Order::query()->latest('id') ->findOrFail($id);
    // $order = $order->toArray();
        return view('client.user.profile.order-profile.index', compact('order'));
   }     

}
