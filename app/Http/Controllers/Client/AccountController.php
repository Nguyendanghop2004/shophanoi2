<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\ForgotPassword;
use App\Models\City;
use App\Models\Order;
use App\Models\Province;
use App\Models\User;
use App\Models\Wards;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Mail;
use Storage;

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

    public function login(LoginRequest $request)
    {
        //  $request->validate([
        //     'email' => 'required|email|exists:users,email',
        //     'password' => 'required|string|min:8',     
        // ]);
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            if (Auth::user()->status) {
                Auth::logout();
                session()->flash('error', 'Tài khoản của bạn đã bị khóa.');
                return redirect()->back();
            }
            return redirect()->route('home')->with('success', 'Đăng nhập thành công');
        }
        return redirect()->back()->with('error', 'Mật khẩu hoặc Email không đúng');
    }
    
    public function logout(Request $request)
    {
        if (Auth::check()) {

            Auth::logout(); // Thực hiện logout
            return redirect()->route('home')->with('success', 'Đăng xuất thành công');

        }
    }
    public function Register(RegisterRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
        ]);

        auth()->login($user);

        return redirect()->route('home')->with('success', 'Đăng ký thành công');
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

    public function ResePasswordIndex()
    {
        return view('client.ResetPassword');
    }
    public function profile(String $id)
    {

        $user = User::findOrFail($id);
        if (auth()->user()->id == $user->id) {
            return view('client.user.profile.profile', compact('user',));
        } else {
            return view('errors.404');
        }
    }
    public function profileOrders()
    {
        $order = Order::query()->get();
        return view('client.user.profile.order', compact('order'));
    }
    public function profileAddress()
    {

        return view('client.user.profile.address');
    }
    public function profileAccountDetails(String $id)
    {
        $user = User::findOrFail($id);
        if (auth()->user()->id == $user->id) {
            $cities = City::orderBy('name_thanhpho', 'ASC')->get();
            $provinces = Province::where('matp', $user->city_id)->orderBy('name_quanhuyen', 'ASC')->get();
            $wards = Wards::where('maqh', $user->province_id)->orderBy('name_xaphuong', 'ASC')->get();
            return view('client.user.profile.account-details', compact('user', 'cities', 'provinces', 'wards'));
        } else {
            return view('errors.404');
        }
    }
    public function storeProfile(Request $request, String $id)
    {
        $dataUser = User::findOrFail($id);
        if ($dataUser->id == auth()->user()->id) {
            $data = $request->only('name', 'email', 'phone_number', 'address', 'city_id', 'province_id', 'wards_id');
            if ($request->password) {
                $data['password'] = Hash::make($request->password);
            } else {
                $data['password'] = $dataUser->password;
            }
            if ($request->hasFile('image')) {

                if ($dataUser->image && Storage::exists($dataUser->image)) {
                    Storage::delete($dataUser->image);
                }

                $data['image'] = Storage::put('public/images/User', $request->file('image'));
            }
            $dataUser->update($data);
            return redirect()->back()->with('success', 'Cập nhật thành công!');
        } else {
            return view('errors.404');
        }
    }
    public function profileWishlist()
    {
        return view('client.user.profile.wishlist');
    }
    public function checkPassword()
    {
        return view('client.user.profile.change.checkpassword');
    }
    public function profileEmail()
    {
        return view('client.user.profile.change.email');
    }
    public function StoreEmail(Request $request, String $id)
    {
        $dataUser = User::query()->findOrFail($id);
        $data = [ 
            'email' => $request->email 
        ];
        $dataUser->update($data);
        return redirect()->route('account.profile',$dataUser->id);
    }
}
