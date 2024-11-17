<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Auth;
use Hash;
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

    public function login(Request $request)
    {
        // dd($request->all());
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Đăng nhập thành công
            $request->session()->regenerate();
            return redirect()->route('home');
        }
    }
    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout(); // Thực hiện logout
            return redirect()->route('home');
        }
    }
    public function Register(RegisterRequest $request)
    {
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Mã hóa mật khẩu
        ]);

        auth()->login($user);

        return redirect()->route('home');
    }
}
