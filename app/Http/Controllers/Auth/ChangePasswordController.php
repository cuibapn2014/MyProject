<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ChangePasswordController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function changePassword(Request $req)
    {
        $user = User::findOrFail(auth()->user()->id);
        $req->validate([
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password'
        ]);
        $user->password = Hash::make($req->new_password);
        $user->remember_token = Str::random(60);

        $user->save();
        return back()->with('success', 'Cập nhật thành công');
    }
}
