<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $finances = Finance::paginate(25)->get();
        return view('admin.manage.provider.provider', compact('providers'));
    }

    public function create(){
        return view('admin.manage.provider.createProvider');
    }

    public function store(Request $req){
        return 0;
    }

    public function edit($id){
        $provider = Finance::findOrFail($id);
        return view('admin.manage.provider.editProvider', compact('provider'));
    }

    public function update(Request $req, $id){
        return 0;
    }

    public function destroy($id){
        Finance::findOrFail($id)->delete();
        return back()->with('success', 'Đã xóa');
    }
}
