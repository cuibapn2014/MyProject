<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class IngredientController extends Controller
{
    //
    public function index()
    {
        return view('admin.manage.ingredient.ingredient', ['ingredient' => Ingredient::all()]);
    }

    public function getAll()
    {
        return response()->json(Ingredient::all());
    }

    public function getStore()
    {
        return view('admin.manage.ingredient.createIngredient');
    }

    public function store(Request $req)
    {
        $this->validate(
            $req,
            [
                'name' => 'required',
                'image.*' => 'required',
                'location' => 'required',
                'phone_number' => 'required|numeric|digits:10',
                'price' => 'required|integer'
            ],
            [
                'name.required' => 'Tên phụ liệu không được để trống',
                'price.required' => 'Giá không được để trống',
                'price.integer' => 'Giá phải là số nguyên',
                'image.*.required' => 'Bạn chưa thêm hình ảnh cho phụ liệu này',
                'location.required' => 'Địa chỉ mua hàng không được để trống',
                'phone_number.required' => 'Số điện thoại không được để trống',
                'phone_number.numeric' => 'Số điện thoại không hợp lệ',
                'phone_number.digits' => 'Số điện thoại không hợp lệ',
            ]
        );
        $ingredient = new Ingredient();
        $ingredient->Ten = $req->name;
        $ingredient->DiaChi = $req->location;
        $ingredient->SoDienThoai = $req->phone_number;
        $ingredient->Gia = $req->price;

        $ingredient->save();
        foreach ($req->file('image') as $image) {
            $photo = new Image();
            if ($image != null) {
                $extension = $image->getClientOriginalExtension();
                $file_name = current(explode('.', $image->getClientOriginalName())) . '_' . time() . '.' . $extension;
                $image->move('img', $file_name);
                $photo->urlImage = $file_name;
                $photo->type = 'pl';
                $photo->id_provide = $ingredient->id;
                $photo->save();
            }
        }

        return back()->with('success', 'Thêm mới thành công');
    }

    public function getUpdate($id)
    {
        return view('admin.manage.ingredient.editIngredient', ['ingredient' => Ingredient::findOrFail($id)]);
    }

    public function update(Request $req, $id)
    {
        $validator =  $this->validate(
            $req,
            [
                'name' => 'required',
                'location' => 'required',
                'phone_number' => 'required|numeric|digits:10',
                'price' => 'required|integer'
            ],
            [
                'name.required' => 'Tên phụ liệu không được để trống',
                'price.required' => 'Giá không được để trống',
                'price.integer' => 'Giá phải là số nguyên',
                'location.required' => 'Địa chỉ mua hàng không được để trống',
                'phone_number.required' => 'Số điện thoại không được để trống',
                'phone_number.numeric' => 'Số điện thoại không hợp lệ',
                'phone_number.digits' => 'Số điện thoại không hợp lệ',
            ]
        );
        if ($req->input('old_image') == null && !$req->hasFile('image'))
            return back()->with('error', 'Bạn không được để trống mục hình ảnh');


        $ingredient = Ingredient::findOrFail($id);
        $ingredient->Ten = $req->name;
        $ingredient->DiaChi = $req->location;
        $ingredient->SoDienThoai = $req->phone_number;
        $ingredient->Gia = $req->price;
        $ingredient->save();

        if ($req->hasFile('image')) {
            foreach ($req->file('image') as $image) {
                $photo = new Image();
                if ($image != null) {
                    $extension = $image->getClientOriginalExtension();
                    $file_name = current(explode('.', $image->getClientOriginalName())) . '_' . time() . '.' . $extension;
                    $image->move('img', $file_name);
                    $photo->urlImage = $file_name;
                    $photo->type = 'pl';
                    $photo->id_provide = $ingredient->id;
                    $photo->save();
                }
            }
        }
        return back()->with('success', 'Cập nhật thành công');
    }

    public function delete($id)
    {
        $images = Image::where('id_provide', $id)->where('type', 'pl')->get();
        if ($images->count() > 0) {
            foreach ($images as $image) {
                File::delete(public_path("img/" . $image->urlImage));
            }
            Image::where('id_provide', $id)->delete();
        }
        Ingredient::findOrFail($id)->where('type', 'pl')->delete();
        return back()->with('success', 'Đã xóa');
    }
}
