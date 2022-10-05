<?php

namespace App\Http\Controllers\Admin;

use App\Exports\IngredientExport;
use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Ingredient;
use App\Models\IngredientType;
use App\Models\Provider;
use App\Models\UnitCalculate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class IngredientController extends Controller
{
    //
    public function index()
    {
        return view('admin.manage.ingredient.ingredient', ['ingredient' => Ingredient::where('id_ingredient_type', 1)->paginate(25)]);
    }

    public function getAllProduct()
    {
        return view('admin.manage.ingredient.product', ['ingredient' => Ingredient::where('id_ingredient_type', '>', 1)->paginate(25)]);
    }

    public function getAll()
    {
        return response()->json(Ingredient::all());
    }

    public function getStore()
    {
        $providers = Provider::where('status','Đang hợp tác')->get();
        $units = UnitCalculate::all();
        $ingredientTypes = IngredientType::all();
        return view('admin.manage.ingredient.createIngredient', compact('providers', 'units', 'ingredientTypes'));
    }

    public function store(Request $req)
    {
        $validator = Validator::make(
            $req->all(),
            [
                'name' => 'required',
                // 'image.*' => 'required',
                'price' => 'integer'
            ],
            [
                'name.required' => 'Tên Nguyên phụ liệu không được để trống',
                // 'price.required' => 'Giá không được để trống',
                'price.integer' => 'Giá phải là số nguyên',
                // 'image.*.required' => 'Bạn chưa thêm hình ảnh cho Nguyên phụ liệu này',
            ]
        );

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();   
        }

        $ingredient = new Ingredient();
        $ingredient->Ten = $req->name;
        $ingredient->id_provider = $req->provider;
        $ingredient->GhiChu = $req->note;

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

        return redirect()->route('admin.ingredient.index')->with('success', 'Thêm mới thành công');
    }

    public function getUpdate($id)
    {
        $providers = Provider::all();
        $ingredient = Ingredient::findOrFail($id);
        return view('admin.manage.ingredient.editIngredient', compact('providers', 'ingredient'));
    }

    public function update(Request $req, $id)
    {
        $validator =  $this->validate(
            $req,
            [
                'name' => 'required',
                'price' => 'integer'
            ],
            [
                'name.required' => 'Tên Nguyên phụ liệu không được để trống',
                // 'price.required' => 'Giá không được để trống',
                'price.integer' => 'Giá phải là số nguyên',
            ]
        );
        if ($req->input('old_image') == null && !$req->hasFile('image'))
            return back()->with('error', 'Bạn không được để trống mục hình ảnh');
        $ingredient = Ingredient::findOrFail($id);
        $ingredient->Ten = $req->name;
        $ingredient->Gia = $req->price;
        $ingredient->GhiChu = $req->note;
        $ingredient->id_provider = $req->provider;
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
        return redirect()->route('admin.ingredient.index')->with('success', 'Cập nhật thành công');
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
        Ingredient::findOrFail($id)->delete();
        return back()->with('success', 'Đã xóa');
    }

    public function export(){
        return Excel::download(new IngredientExport, 'phu_lieu.xlsx');
    }
}
