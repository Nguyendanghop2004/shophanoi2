<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\ForgotPassword;
use App\Models\City;
use App\Models\History;
use App\Models\Order;
use App\Models\Product;
use App\Models\Province;
use App\Models\User;
use App\Models\Wards;
use App\Models\Wishlist;
use Auth;
use Crypt;
use DB;
use Hash;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    public function login(\App\Http\Requests\Client\LoginRequest $request)
    {


        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            // Đăng nhập thành công
            if (Auth::user()->status) {
                Auth::logout();
                return back()->with('error', 'Tài khoản của bạn đã bị khóa.');
            }
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Đăng nhập thành công');
        }


        return back()->with([
            'error' => 'Mật khẩu hoặc Email không đúng.',
        ]);
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

    public function ResePasswordIndex(){
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
    public function profileOrders(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/');
        }
    
        $user = Auth::user();
        
        $status = $request->query('status', '');
        
        $query = Order::where('user_id', $user->id);
        
        if ($status !== '') {
            $query->where('status', $status);
        }
        
        $order = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('client.user.profile.order', compact('order', 'status'));
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
    public function ProfileUpdate(Request $request, string $id)
    {
        $dataUser = User::findOrFail($id);
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
        $idadmin = Auth()->user()->id;
        $data1 = $dataUser->toArray();
        History::create([
            'user_id' =>  $dataUser->id,
            'action' => 'update',
            'model_type' => Auth()->user()->name,
            'model_id' =>  $idadmin,
            'changes' => array_diff($data1, $data),
        ]);
        $dataUser->update($data);
        return redirect()->back()->with('success', 'Cập nhật thành công!');
    }

    public function profileWishlist()
    {
        if (!Auth::check()) {
            return redirect()->route('accountUser.login')->with('error', 'Bạn cần đăng nhập để xem danh sách yêu thích.');
        }


        $userId = Auth::id();


        $wishlistProductIds = Wishlist::where('user_id', $userId)->pluck('product_id')->toArray();

        if (empty($wishlistProductIds)) {
            return view('client.user.profile.wishlist', ['message' => 'Danh sách yêu thích của bạn trống.']);
        }


        $products = Product::query()
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('product_images', 'products.id', '=', 'product_images.product_id')
            ->with([
                'colors' => fn($query) => $query->select('colors.id', 'colors.name', 'colors.sku_color'),
                'images' => fn($query) => $query->select('product_images.id', 'product_images.product_id', 'product_images.color_id', 'product_images.image_url'),
            ])
            ->select([
                'products.id',
                'products.product_name',
                'products.price',
                'products.slug',
                DB::raw('COUNT(DISTINCT product_variants.size_id) as distinct_size_count'),
                DB::raw('(SELECT SUM(stock_quantity) FROM product_variants WHERE product_variants.product_id = products.id) as total_stock_quantity')
            ])
            ->whereIn('products.id', $wishlistProductIds)
            ->groupBy('products.id')
            ->get();

        $products = $products->map(function ($product) {

            $imagesByColor = $product->images->groupBy('color_id');


            $product->colors = $product->colors->map(function ($color) use ($imagesByColor) {
                $images = $imagesByColor->get($color->id, collect());
                $mainImage = $images->first()?->image_url ?? null;
                $hoverImage = $images->skip(1)->first()?->image_url ?? null;

                return [
                    'id' => $color->id,
                    'name' => $color->name,
                    'sku_color' => $color->sku_color,
                    'main_image' => $mainImage,
                    'hover_image' => $hoverImage,
                ];
            });


            $firstColor = $product->colors->first();
            $product->main_image_url = $firstColor ? $firstColor['main_image'] : null;
            $product->hover_main_image_url = $firstColor ? $firstColor['hover_image'] : null;


            return [
                'id' => $product->id,
                'name' => $product->product_name,
                'price' => $product->price,
                'slug' => $product->slug,
                'distinct_size_count' => $product->distinct_size_count,
                'total_stock_quantity' => $product->total_stock_quantity,
                'main_image_url' => $product->main_image_url,
                'hover_main_image_url' => $product->hover_main_image_url,
                'colors' => $product->colors,
            ];
        });
        $wishlist = [];

        if (Auth::check()) {

            $wishlist = Wishlist::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();
        }

        return view('client.user.profile.wishlist', compact('products', 'wishlist'));
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
        return redirect()->route('account.profile', $dataUser->id);
    }
    public function checkPasswordProfile(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        if (Hash::check($request->password, auth()->user()->password)) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 401);
    }
    public function editPassword()
    {
        $id = Auth::id();
        $dataUser = User::query()->findOrFail($id);
        return view('client.user.profile.change.indexpassword', compact('dataUser'));
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ], [
            'old_password.required' => 'Mật khẩu cũ là bắt buộc.',
            'password.required' => 'Mật khẩu mới là bắt buộc.',
            'password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Mật khẩu mới và xác nhận mật khẩu không khớp.',
            'password_confirmation.required' => 'Xác nhận mật khẩu là bắt buộc.',
        ]);
        // dd($request->all());
        if (Hash::check($request->old_password, Auth::user()->password)) {
            Auth::user()->update([
                'password' => Hash::make($request->password),
            ]);
            return back()->with('success', 'Đổi mật khẩu thành công');
        } else {
            return back()->with('error', 'Mật khẩu cũ không chính xác');
        }
    }
}
