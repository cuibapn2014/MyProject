<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fabric;
use Illuminate\Http\Request;

class FabricController extends Controller
{
    //
    public function index()
    {
        return view('admin.manage.fabric', ['fabric' => Fabric::all()]);
    }

    public function store(Request $req)
    {
        $this->validate(
            $req,
            [
                'name' => 'required',
                'color' => 'required',
                'property' => 'required',
                'price' => 'required|integer',
                'location' => 'required'
            ],
            [
                'name.required' => 'Tên loại vải không được để trống',
                'color.required' => 'Màu loại vải không được để trống',
                'property.required' => 'Tính chất loại vải không được để trống',
                'price.required' => 'Giá tiền không được để trống',
                'price.integer' => 'Giá tiền phải là số nguyên',
                'location.required' => 'Địa chỉ mua hàng không được để trống'
            ]
        );

        $fabric = new Fabric();
        $fabric->Ten = $req->name;
        $fabric->MauSac = $req->color;
        $fabric->TinhChat = $req->property;
        $fabric->GhiChu = $req->GhiChu;
        $fabric->Gia = $req->price;
        $fabric->DiaChiMua = $req->location;
        $fabric->save();
        return back()->with('success', 'Thêm thành công');
    }

    public function update(Request $req, $id)
    {
        $this->validate(
            $req,
            [
                'name' => 'required',
                'color' => 'required',
                'property' => 'required',
                'price' => 'required|integer',
                'location' => 'required'
            ],
            [
                'name.required' => 'Tên loại vải không được để trống',
                'color.required' => 'Màu loại vải không được để trống',
                'property.required' => 'Tính chất loại vải không được để trống',
                'price.required' => 'Giá tiền không được để trống',
                'price.integer' => 'Giá tiền phải là số nguyên',
                'location.required' => 'Địa chỉ mua hàng không được để trống'
            ]
        );

        $fabric = Fabric::findOrFail($id);
        $fabric->Ten = $req->name;
        $fabric->MauSac = $req->color;
        $fabric->TinhChat = $req->property;
        $fabric->GhiChu = $req->GhiChu;
        $fabric->Gia = $req->price;
        $fabric->DiaChiMua = $req->location;
        $fabric->save();
        return back()->with('success', 'Cập nhật thành công');
    }

    public function delete($id)
    {
        Fabric::findOrFail($id)->delete();
        return back()->with('success', 'Đã xóa');
    }
}
