<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $alias = $user->role->alias;
            if($user->status != 1){
                Auth::logout();
                return redirect()->route('login')->with(['failed' => 'Tài khoản của bạn đã bị khóa']);
            }
            if ($alias != 'CUSTOMER')
                return $next($request);
        }
        return redirect()->route('home')->with('isAdmin', 'Không được phép truy cập! Do bạn không phải là nhân viên');
    }
}
