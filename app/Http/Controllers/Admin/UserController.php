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

    public function index(Request $request)
    {
        $users = User::where('name', 'like', '%' . $request->keyword . '%')
            ->orWhere('phone', 'like', '%' . $request->keyword . '%')
            ->orWhere('email', 'like', '%' . $request->keyword . '%')
            ->orWhereRelation('role', 'name', 'like', '%' . $request->keyword . '%')
            ->orderBy('name')
            ->paginate(25);
        $roles = Role::orderBy('name')->get();

        return view('admin.manage.users.index', compact('users', 'roles'));
    }

    public function updateStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $getRole = $user->role->firstWhere('id', $request->role);

        if ($getRole != null && $getRole->alias == 'ADMIN' && auth()->user()->role->alias != 'ADMIN') {
            return back()->with('failed', 'Không thể cập nhật bản thân thành Quản trị viên');
        }

        if (
            in_array(auth()->user()->role->alias, ['ADMIN', 'USER_HR', 'CEO', 'USER_MANAGER'])
            && !in_array($user->role->alias, ['ADMIN', 'CEO'])
        ) {
            $user->update([
                'status' => $request->status,
                'id_role' => $request->role
            ]);

            return back()->with('success', 'Cập nhật thành công');
        }
        return back()->with('failed', 'Không thể cập nhật');
    }
}
