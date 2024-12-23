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


        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->status) {
                Auth::logout();
                session()->flash('error', 'Tài khoản của bạn đã bị khóa.');
                return redirect()->back();
            }
    
            // Đăng nhập thành công
            return redirect()->intended('/');
        }
    
        session()->flash('error', 'Email hoặc mật khẩu không đúng.');
        return redirect()->back();
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
    public function loginIndex()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
    
        return response()->view('client.login')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function RegisterIndex()
    {
        return view('client.register');
    }
}
