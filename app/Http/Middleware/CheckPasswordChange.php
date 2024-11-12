<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    //   $data =Auth::user()->password;
      
    // //   dd( $admin->password);
   
    //     if (Auth::check() && $data ) {
    //         Auth::logout();
    //         return redirect('/login')->with('erro', 'Mật khẩu của bạn đã được thay đổi. Vui lòng đăng nhập lại.');
    //     }

        return $next($request);
    }
}
