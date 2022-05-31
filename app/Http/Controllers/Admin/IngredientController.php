<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    //
    public function index()
    {
        return view('admin.manage.ingredient', ['ingredient' => Ingredient::all()]);
    }

    public function store(Request $req)
    {
        $this->validate(
            $req,
            [
                'name' => 'required',
                'image' => 'required'
            ],
            [
                'name.required' => 'Tên phụ liệu không được để trống',
                'image.required' => 'Bạn chưa thêm hình ảnh cho phụ liệu này'
            ]
        );
        $ingredient = new Ingredient();
        $ingredient->Ten = $req->name;
        $ingredient->HinhAnh = $req->image;
        $ingredient->save();
        return back()->with('success', 'Cập nhật thành công');
    }

    public function update(Request $req, $id)
    {
        $this->validate(
            $req,
            [
                'name' => 'required',
                'image' => 'required'
            ],
            [
                'name.required' => 'Tên phụ liệu không được để trống',
                'image.required' => 'Bạn chưa thêm hình ảnh cho phụ liệu này'
            ]
        );
        $ingredient = Ingredient::findOrFail($id);
        $ingredient->Ten = $req->name;
        $ingredient->HinhAnh = $req->image;
        $ingredient->save();
        return back()->with('success', 'Cập nhật thành công');
    }

    public function delete($id)
    {
        return back()->with('success', 'Đã xóa');
    }
}
