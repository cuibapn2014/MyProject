<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequestProduction;
use Illuminate\Http\Request;

class RequirementController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:ADMIN,CEO,USER_ACCOUNTANT,USER_SALES');
    }

    public function index()
    {
        $requirements = RequestProduction::orderByDesc('id')->paginate(25);
        return view('admin.manage.requirements.index', compact('requirements'));
    }

    public function updateStatus(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|min:1|max:4'
        ]);
        $requestProduction = RequestProduction::findOrFail($id);
        $requestProduction->update([
            'status' => $request->status
        ]);
        return back()->with('success', 'Cập nhật thành công');
    }
}