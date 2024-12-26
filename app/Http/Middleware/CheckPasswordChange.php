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
        $admin = Auth::user();
        if (!$admin->check) {
            // dd(1);
            Auth::logout();
            return redirect()->route('accountUser.login')->withErrors(['email' => 'Tài khoản của bạn đã bị thay đổi mật khẩu.']);

        }
        return $next($request);
    }
}
