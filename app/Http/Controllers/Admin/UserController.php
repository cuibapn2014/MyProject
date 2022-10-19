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
        $user->update([
            'status' => $request->status,
            'id_role' => $request->role
        ]);
        return back()->with('success', 'Cập nhật thành công');
    }
}
