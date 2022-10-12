<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $users = User::where('id_role', '<>', 3)->orderByDesc('id_role')->paginate(25);

        return view('admin.manage.users.index', compact('users'));
    }
}
