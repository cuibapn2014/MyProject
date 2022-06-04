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

    public function getAll(){
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
                'image.*' => 'required'
            ],
            [
                'name.required' => 'Tên phụ liệu không được để trống',
                'image.*.required' => 'Bạn chưa thêm hình ảnh cho phụ liệu này'
            ]
        );
        $ingredient = new Ingredient();
        $ingredient->Ten = $req->name;
        $ingredient->save();
        foreach ($req->file('image') as $image) {
            $photo = new Image();
            if ($image != null) {
                $extension = $image->getClientOriginalExtension();
                $file_name = current(explode('.', $image->getClientOriginalName())) . '_' . time() . '.' . $extension;
                $image->move('img', $file_name);
                $photo->urlImage = $file_name;
                $photo->id_PhuLieu = $ingredient->id;
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
        $validator = $this->validate(
            $req,
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Tên phụ liệu không được để trống',
            ]
        );
        if ($req->input('old_image') == null && !$req->hasFile('image'))
            return back()->with('error', 'Bạn không được để trống mục hình ảnh');


        $ingredient = Ingredient::findOrFail($id);
        $ingredient->Ten = $req->name;
        $ingredient->save();

        if ($req->hasFile('image')) {
            foreach ($req->file('image') as $image) {
                $photo = new Image();
                if ($image != null) {
                    $extension = $image->getClientOriginalExtension();
                    $file_name = current(explode('.', $image->getClientOriginalName())) . '_' . time() . '.' . $extension;
                    $image->move('img', $file_name);
                    $photo->urlImage = $file_name;
                    $photo->id_PhuLieu = $ingredient->id;
                    $photo->save();
                }
            }
        }
        return back()->with('success', 'Cập nhật thành công');
    }

    public function delete($id)
    {
        $images = Image::where('id_PhuLieu', $id)->get();
        if ($images->count() > 0) {
            foreach ($images as $image) {
                File::delete(public_path("img/".$image->urlImage));
            }
            Image::where('id_PhuLieu', $id)->delete();
        }
        Ingredient::findOrFail($id)->delete();
        return back()->with('success', 'Đã xóa');
    }
}
