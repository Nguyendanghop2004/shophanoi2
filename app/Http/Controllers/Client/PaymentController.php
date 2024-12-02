<?php

namespace App\Http\Controllers\Client;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class PaymentController extends Controller
{
    public function confirmation()
    {
        $categories = Category::with(relations: [
            'children' => function ($query) {
                $query->where('status', 1);
            }
        ])->where('status', 1)
            ->whereNull('parent_id')->get();
        return view('client.payment-confirmation',compact('categories'));
    }
    public function failure()
    {
        return view('client.payment-failure');
    }
    // app/Http/Controllers/PaymentController.php

    public function vnpayReturn(Request $request)
    {
        $vnp_HashSecret = "QILK1HU3OIQHN2B6P9LKCZFL1RAEF0L4";
        $inputData = $request->all();
        
        $secureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        
        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= '&' . $key . "=" . $value;
        }
        $hashData = ltrim($hashData, '&');
        $checkHash = hash('sha256', $vnp_HashSecret . $hashData);

        if ($checkHash === $secureHash) {
            if ($inputData['vnp_ResponseCode'] === '00') {
                $order = Order::where('order_code', $inputData['vnp_TxnRef'])->first();
                $order->payment_status = 1;
                $order->save();

                return redirect()->route('home')->with('success', 'Thanh toán thành công');
            } else {
                return redirect()->route('home')->with('error', 'Thanh toán thất bại');
            }
        } else {
            return redirect()->route('home')->with('error', 'Lỗi bảo mật, vui lòng thử lại');
        }
    }
}
