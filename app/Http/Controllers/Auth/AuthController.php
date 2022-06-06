<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
                'email' => 'required|email',
                'password' => 'required|min:8'
            ],
            [
                'email.required' => 'Email không được để trống',
                'email.email' => 'Email của bạn cung cấp không hợp lệ',
                'password.required' => 'Mật khẩu không được để trống',
                'password.min' => 'Mật khẩu ít nhất phải từ 8 ký tự'
            ]
        );

        $credentials = $req->only('email', 'password');
        $remember = $req->remember == 'on' ? true : false;
        if (Auth::attempt($credentials, $remember)) {
            $redirect = Auth::user()->role > 0 ?
                redirect()->route('admin.home')->with('success', 'Logined success!') :
                redirect()->route('home')->with('success', 'Logined success!');
            return $redirect;
        }

        return back()->with('failed', 'Email hoặc mật khẩu không chính xác! Vui lòng thử lại');
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
                'password' => 'required|min:8'
            ],
            [
                'fullname.min' => 'Tên của bạn ít nhất phải từ 6 ký tự',
                'fullname.required' => 'Tên của bạn không được để trống',
                'email.required' => 'Email của bạn không được để trống',
                'email.unique' => 'Địa chỉ email của bạn đã tồn tại trong hệ thống',
                'email.email' => 'Địa chỉ email của bạn cucng cấp không hợp lệ',
                'password.required' => 'Mật khẩu của bạn không được để trống',
                'password.min' => 'Mật khẩu của bạn phải ít nhất từ 8 ký tự'
            ]
        );
        $user = new User();
        $user->name = $req->fullname;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->role = 1;
        $user->save();

        return back()->with('success', 'Đăng ký thành công!');
    }
}
