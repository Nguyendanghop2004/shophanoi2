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

        if (Auth::check()) {
            if (Auth::user()->status) {
                // dd(1);
                Auth::logout();
                return redirect()->route('accountUser.login')->with('error', 'Tài khoản của bạn đã bị khóa',);
            }
        }
        return $next($request);
    }
}
