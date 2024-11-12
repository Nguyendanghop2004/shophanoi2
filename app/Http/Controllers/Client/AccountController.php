<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function acc(Request $request, $section = null)
    {
        if ($request->ajax()) {
            switch ($section) {
                case 'orders':
                    return view('client.layouts.particals.account.orders');
                case 'dashboard':
                    return view('client.layouts.particals.account.dashboard');
                default:
                    return view('client.layouts.particals.account.dashboard');
            }
        }
        return view('client.my-account', ['section' => $section]);
    }

    public function login()
    {
        dd(1);
    }
}
