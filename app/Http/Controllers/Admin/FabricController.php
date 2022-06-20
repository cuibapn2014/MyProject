<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fabric;
use App\Models\Image;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FabricExport;
use Illuminate\Support\Facades\Validator;

class FabricController extends Controller
{
    //
    public function index()
    {
        return view('admin.manage.fabric.fabric', ['fabrics' => Fabric::paginate(25)]);
    }

    public function getAll()
    {
        return response()->json(Fabric::all());
    }

    public function getStore()
    {
        return view('admin.manage.fabric.createFabric');
    }


    public function store(Request $req)
    {
        $validator = Validator::make(
            $req->all(),
            [
                // 'name' => 'required',
                // 'color' => 'required',
                // 'property' => 'required',
                'price' => 'integer',
                // 'location' => 'required',
                // 'image.*' => 'required',
                'phone_number' => 'numeric|digits:10',
            ],
            [
                // 'name.required' => 'Tên loại vải không được để trống',
                // 'color.required' => 'Màu loại vải không được để trống',
                // 'property.required' => 'Tính chất loại vải không được để trống',
                // 'price.required' => 'Giá tiền không được để trống',
                'price.integer' => 'Giá tiền phải là số nguyên',
                // 'location.required' => 'Địa chỉ mua hàng không được để trống',
                // 'image.*.required' => 'Bạn chưa thêm hình ảnh cho loại vải này',
                // 'phone_number.required' => 'Số điện thoại không được để trống',
                'phone_number.numeric' => 'Số điện thoại không hợp lệ',
                'phone_number.digits' => 'Số điện thoại không hợp lệ',
            ]
        );

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();   
        }

        $fabric = new Fabric();
        $fabric->Ten = $req->name;
        $fabric->MauSac = $req->color;
        $fabric->TinhChat = $req->property;
        $fabric->GhiChu = $req->GhiChu;
        $fabric->Gia = $req->price;
        $fabric->DiaChiMua = $req->location;
        $fabric->SoDienThoai = $req->phone_number;
        $fabric->save();

        if ($req->hasFile('image')) {
            foreach ($req->file('image') as $image) {
                $photo = new Image();
                if ($image != null) {
                    $extension = $image->getClientOriginalExtension();
                    $file_name = current(explode('.', $image->getClientOriginalName())) . '_' . time() . '.' . $extension;
                    $image->move('img', $file_name);
                    $photo->urlImage = $file_name;
                    $photo->type = 'lv';
                    $photo->id_provide = $fabric->id;
                    $photo->save();
                }
            }
        }

        return redirect()->route('admin.fabric.index')->with('success', 'Thêm thành công');
    }

    public function getUpdate($id)
    {
        return view('admin.manage.fabric.editFabric', ['fabric' => Fabric::findOrFail($id)]);
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
        $fabric->GhiChu = $req->note;
        $fabric->Gia = $req->price;
        $fabric->DiaChiMua = $req->location;
        $fabric->SoDienThoai = $req->phone_number;
        $fabric->save();

        if ($req->hasFile('image')) {
            foreach ($req->file('image') as $image) {
                $photo = new Image();
                if ($image != null) {
                    $extension = $image->getClientOriginalExtension();
                    $file_name = current(explode('.', $image->getClientOriginalName())) . '_' . time() . '.' . $extension;
                    $image->move('img', $file_name);
                    $photo->urlImage = $file_name;
                    $photo->type = 'lv';
                    $photo->id_provide = $fabric->id;
                    $photo->save();
                }
            }
        }
        return redirect()->route('admin.fabric.index')->with('success', 'Cập nhật thành công');
    }

    public function delete($id)
    {
        Fabric::findOrFail($id)->delete();
        return back()->with('success', 'Đã xóa');
    }

    public function export(){
        return Excel::download(new FabricExport, 'loai_vai.xlsx');
    }
}
