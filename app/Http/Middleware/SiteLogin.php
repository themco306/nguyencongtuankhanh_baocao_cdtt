<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SiteLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('users')->check()) {

            return redirect()->route('site.getlogin')->with('message', ['type' => 'danger', 'msg' => 'Vui lòng đăng nhập']);
        } else {
            if (Auth::guard('users')->user()->status == 2) {
                Auth::guard('users')->logout();
                return redirect()->route('site.getlogin')->with('message', ['type' => 'danger', 'msg' => 'Bạn chưa xác minh tài khoản']);
            }
            if (Auth::guard('users')->user()->status == 0) {
                Auth::guard('users')->logout();
                return redirect()->route('site.getlogin')->with('message', ['type' => 'danger', 'msg' => 'Tài khoản của bạn đã bị xóa']);
            }
        }
        return $next($request);
    }
}
