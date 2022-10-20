<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FinanceRequest;
use App\Models\Finance;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:ADMIN,CEO,USER_ACCOUNTANT,USER_SALES');
    }

    public function index(){
        $finances = Finance::orderBy('status')->orderByDesc('id')->paginate(25);
        return view('admin.manage.finances.index', compact('finances'));
    }

    public function create(Request $request){
        $title = $request->type == 2 ? "Phiếu chi" : "Phiếu thu";
        $count = Finance::count() + 1;
        $alias = $request->type ? 'PC' : 'PT';
        $code = $alias . str_pad($count, 6, "0", STR_PAD_LEFT);
        return view('admin.manage.finances.create', compact('title', 'code'));
    }

    public function store(FinanceRequest $req){
        $dataCreate = $req->all();
        $dataCreate['id_user'] = auth()->user()->id;
        Finance::create($dataCreate);
        return redirect()->route('admin.finance.index')->with('success', 'Tạo mới thành công');
    }

    public function edit(Request $request, $id){
        $title = $request->type == 1 ? "Phiếu thu" : "Phiếu chi";
        $finance = Finance::findOrFail($id);
        return view('admin.manage.finances.edit', compact('finance', 'title'));
    }

    public function update(FinanceRequest $req, $id){
        $finance = Finance::findOrFail($id);
        $finance->update($req->all());
        return redirect()->route('admin.finance.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy($id){
        Finance::findOrFail($id)->delete();
        return back()->with('success', 'Đã xóa');
    }

    public function updateStatus($id, $status)
    {
        $finance = Finance::findOrFail($id);
        
        $finance->update([
            'status' => $status,
            'reviewer_date' => \Carbon\Carbon::now()
        ]);

        return back()->with('success', 'Cập nhật trạng thái thành công');
    }
}
