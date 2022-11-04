<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProviderRequest;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProviderController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:ADMIN,CEO,USER_ACCOUNTANT,USER_SALES,USER_MANAGER');
    }

    public function index(Request $request)
    {
        $providers = Provider::where('name', 'like', '%'.$request->keyword.'%')
        ->orWhere('address', 'like', '%'.$request->keyword.'%')
        ->orWhere('phone_number', 'like', '%'.$request->keyword.'%')
        ->orderByDesc('id')
        ->paginate(25);
        return view('admin.manage.provider.provider', compact('providers'));
    }

    public function create()
    {
        return view('admin.manage.provider.createProvider');
    }

    public function store(ProviderRequest $req)
    {
        DB::beginTransaction();
        try {
            $provider = Provider::create($req->all());
            $provider->status = $req->status;
            $provider->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            throw $ex;
        }
        return back()->with('success', 'Thêm thành công');
    }

    public function edit($id)
    {
        $provider = Provider::findOrFail($id);
        return view('admin.manage.provider.editProvider', compact('provider'));
    }

    public function update(Request $req, $id)
    {
        DB::beginTransaction();
        try {
            $provider = Provider::findOrFail($id);
            $provider->update($req->all());
            $provider->status = $req->status;
            $provider->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            throw $ex;
        }
        return back()->with('success', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            Provider::findOrFail($id)->delete();
            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
        }
        return back()->with('success', 'Đã xóa');
    }
}
