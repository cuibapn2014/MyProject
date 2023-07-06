<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $data = $request;
        Validator::extend('is_lock', function($attribute, $value, $param, $validate) use ($request){
            $user = User::where('email', $value)->first();
            if(!$user) return true;
            if($user->status == 2) return false;
            return true;
        });
        Validator::extend('is_not_use', function($attribute, $value, $param, $validate) use ($request){
            $user = User::where('email', $value)->first();
            if(!$user) return true;
            if($user->status == 3) return false;
            return true;
        });
        $validator = Validator::make($data->all(), [
            'email' => 'required|email|is_lock|is_not_use|exists:users,email',
            'password' => 'required|string|min:6',
        ],[
            'email.required' => 'Email không được để trống',
            'email.exists' => 'Email chưa được đăng ký',
            'password.required' => 'Mật khẩu không được để trống',
            'email' => 'Email không hợp lệ',
            'is_lock' => 'Tài khoản của bạn đang tạm khóa',
            'is_not_use' => 'Tài khoản đã ngừng sử dụng'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $minutes = $request->remember ? (60 * 24 * 30) : 60; 
        if (!$token = auth()->setTTL($minutes)->attempt($validator->validated())) {
            return response()->json(['error' => 'Mật khẩu không chính xác'], 401);
        }
        $cookie = $this->getCookie($token);
        $user = User::find(auth()->user()->id);
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $user->last_login_at = date("Y-m-d H:i");
        $user->ip_last_login = $request->ip();
        $user->save();

        return $this->createNewToken($token)->withCookie($cookie);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|string|same:password'
        ],[
            'required' => 'Không được bỏ trống',
            'string' => 'Giá trị phải là chuỗi ký tự',
            'email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại',
            'password.min' => 'Mật khẩu ít nhất 6 ký tự',
            'password.same' => 'Mật khẩu không trùng khớp'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            [
                'password' => bcrypt($request->password),
                'id_role' => 3
            ]
        ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    public function changePassWord(Request $request)
    {
        $data = $request;
        $id = auth()->user()->id;
        $user = User::findOrFail($id);
        $checkPassword = Hash::check($data->current_password, $user->password);
        if(!$checkPassword)
            return response()->json(['message' => 'Mật khẩu hiện tại không chính xác'], 400);
        $validator = Validator::make($data->all(), [
            'current_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6|different:current_password',
            'confirm_password' => 'required|string|min:6|same:new_password',
        ],[
            'required' => 'Không được để trống',
            'min' => 'Mật khẩu ít nhất phải 6 ký tự',
            'different' => 'Hãy đặt mật khẩu khác với mật khẩu ban đầu',
            'same' => 'Mật khẩu không trùng khớp'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user->update(
            ['password' => bcrypt($request->new_password)]
        );

        return response()->json([
            'message' => 'User successfully changed password',
            'user' => $user,
        ], 201);
    }

    public function update(Request $request)
    {
        $data = $request;
        $id = auth()->user()->id;
        $validator = Validator::make($data->all(), [
            'name' => 'required',
            'phone' => 'required|numeric|digits:10'
        ],[
            'required' => 'Không được để trống',
            'numeric' => 'Số điện thoại không hợp lệ',
            'digits' => 'Số điện thoại không hợp lệ'
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toJson(), 500);

        $user = User::findOrFail($id);
        if($validator->validated()){
            $user->update([
                'name' => $data['name'],
                'phone' => $data['phone']
            ]);
        }

        return response()->json(['message' => 'Cập nhật thành công', 'user' => $user], 200);
    }

    /**
     * Set cookie details and return cookie
     *
     * @param string $token JWT
     *
     * @return \Illuminate\Cookie\CookieJar|\Symfony\Component\HttpFoundation\Cookie
     */
    private function getCookie($token)
    {
        return cookie(
            "token",
            $token,
            auth()->factory()->getTTL(),
            null,
            null,
            true,//env('APP_DEBUG') ? false : true,
            true,//true httponly
            false,
            'none' //SameSite
        );
    }
}
