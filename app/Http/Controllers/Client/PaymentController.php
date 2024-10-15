<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function confirmation()
    {
        return view('client.payment-confirmation');
    }
    public function failure()
    {
        return view('client.payment-failure');
    }
}
