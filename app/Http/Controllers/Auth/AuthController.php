<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $req)
    {
        $this->validate(
            $req,
            [
                'email' => 'required',
                'password' => 'required'
            ],
            [
                'required' => 'Tài khoản hoặc mật khẩu không được để trống'
            ]
        );

        $credentials = $req->only('email', 'password');
        // $credentials['status'] = 1;
        $remember = $req->remember == 'on' ? true : false;
        if (Auth::attempt($credentials, $remember)) {
            if (auth()->user()->role->alias != 'CUSTOMER')
                return redirect('/admin')->with('success', 'Logined success!');
            return redirect('/')->with('success', 'Logined success!');
        }

        return back()->withInput()->with('failed', 'Email hoặc mật khẩu không chính xác');
    }

    public function getRegister()
    {
        return view('auth.register');
    }

    public function register(Request $req)
    {
        $this->validate(
            $req,
            [
                'fullname' => 'required|min:6',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|confirmed'
            ],
            [
                'fullname.min' => 'Tên của bạn ít nhất phải từ 6 ký tự',
                'fullname.required' => 'Tên của bạn không được để trống',
                'email.required' => 'Email của bạn không được để trống',
                'email.unique' => 'Địa chỉ email của bạn đã tồn tại trong hệ thống',
                'email.email' => 'Địa chỉ email của bạn cucng cấp không hợp lệ',
                'password.required' => 'Mật khẩu của bạn không được để trống',
                'password.min' => 'Mật khẩu của bạn phải ít nhất từ 8 ký tự',
                'password.confirmed' => 'Xác nhận mật khẩu không trùng khớp'
            ]
        );
        $user = new User();
        $user->name = $req->fullname;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->id_role = 3;
        $user->save();

        return back()->with('success', 'Đăng ký thành công!');
    }

    public function forgotPassword()
    {
        return view('auth.forgotPassword');
    }

    public function postForgotPassword(Request $req)
    {
        $this->validate($req, [
            'email' => 'required|email'
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không hợp lệ'
        ]);

        $status = Password::sendResetLink(
            $req->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetPassword(Request $req, $token)
    {
        return view('auth.resetPassword', ['token' => $token, 'email' => $req->only('email')['email']]);
    }

    public function updatePassword(Request $req)
    {
        $req->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $status = Password::reset(
            $req->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
