<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:USER_SALES,ADMIN,CEO');
    }

    public function index()
    {
        $customers = Customer::paginate(25);

        return view('admin.manage.customer.customer', compact('customers'));
    }

    public function create()
    {
        return view('admin.manage.customer.createCustomer');
    }

    public function store(CustomerRequest $request)
    {
        DB::beginTransaction();
        try {
            $customer = Customer::create($request->all());
            $customer->creator = auth()->user()->id;
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            throw $ex;
        }
        return back()->with('success', 'Thêm thành công');
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);

        return view('admin.manage.customer.editCustomer', compact('customer'));
    }

    public function update(CustomerRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $customer = Customer::findOrFail($id);
            $customer->update($request->all());
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
        try {
            $customer = Customer::findOrFail($id);
            $customer->delete();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            throw $ex;
        }
        return back()->with('success', 'Đã xóa khách hàng');
    }
}
