<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::orderByDesc('id_role')->paginate(25);
        $roles = Role::all();

        return view('admin.manage.users.index', compact('users','roles'));
    }

    public function updateStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if(in_array(auth()->user()->role->alias, ['ADMIN', 'USER_HR', 'CEO']) 
        && ($user->role->alias != 'ADMIN' || auth()->user()->role->alias == $user->role->alias)){
            $user->update([
                'status' => $request->status,
                'id_role' => $request->role
            ]);
        return back()->with('success', 'Cập nhật thành công');
        }
        return back()->with('failed', 'Không thể cập nhật do không đủ thẩm quyền');
    }
}
