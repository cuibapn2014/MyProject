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
    public function index(Request $request)
    {
        $ingredient = Ingredient::where(function($query) use($request){
            $query->where('Ten', 'like', '%'.$request->keyword.'%')
            ->orWhereRelation('provider', 'name', 'like', '%'.$request->keyword.'%')
            ->orWhereRelation('provider', 'address', 'like', '%'.$request->keyword.'%')
            ->orWhereRelation('provider', 'phone_number', 'like', '%'.$request->keyword.'%')
            ->orWhere('GhiChu', 'like', '%'.$request->keyword.'%')
            ->orWhere('code', 'like', '%'.$request->keyword.'%');
        })
        ->where('id_ingredient_type', 1)->paginate(25);
        return view('admin.manage.ingredient.ingredient', compact('ingredient'));
    }

    public function getAllProduct(Request $request)
    {
        $ingredient = Ingredient::where(function($query) use($request){
            $query->where('Ten', 'like', '%'.$request->keyword.'%')
            ->orWhereRelation('provider', 'name', 'like', '%'.$request->keyword.'%')
            ->orWhereRelation('provider', 'address', 'like', '%'.$request->keyword.'%')
            ->orWhereRelation('provider', 'phone_number', 'like', '%'.$request->keyword.'%')
            ->orWhere('GhiChu', 'like', '%'.$request->keyword.'%')
            ->orWhere('code', 'like', '%'.$request->keyword.'%');
        })
        ->where('id_ingredient_type', '>',1)->paginate(25);
        return view('admin.manage.ingredient.product', compact('ingredient'));
    }

    public function getAll()
    {
        return response()->json(Ingredient::all());
    }

    public function getStore(Request $request)
    {
        $providers = Provider::where('status', 'Đang hợp tác')->get();
        $units = UnitCalculate::all();
        $ingredientTypes = IngredientType::all();
        $title = $request->type == 1 ? "Thành phẩm" : "Nguyên phụ liệu";
        $char = $request->type == 1 ? "MTP" : "MVT";
        $count = Ingredient::count() + 1;
        $code = $char . str_pad($count, 6, '0', STR_PAD_LEFT);
        return view('admin.manage.ingredient.createIngredient', compact('providers', 'units', 'ingredientTypes', 'title', 'code'));
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

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $ingredient = new Ingredient();
        $ingredient->Ten = $req->name;
        $ingredient->id_ingredient_type = $req->id_ingredient_type;
        $ingredient->id_unit = $req->id_unit;
        $ingredient->id_provider = $req->provider;
        $ingredient->GhiChu = $req->note;
        $ingredient->Gia = $req->price;

        $ingredient->save();
        if ($req->file('image')) {
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

        return redirect()->route('admin.ingredient.index')->with('success', 'Thêm mới thành công');
    }

    public function getUpdate(Request $request, $id)
    {
        $providers = Provider::all();
        $ingredient = Ingredient::findOrFail($id);
        $ingredientTypes = IngredientType::all();
        $title = $request->type == 1 ? "Thành phẩm" : "Nguyên phụ liệu";
        return view('admin.manage.ingredient.editIngredient', compact('providers', 'ingredient', 'title'));
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
        // if ($req->input('old_image') == null && !$req->hasFile('image'))
        //     return back()->with('error', 'Bạn không được để trống mục hình ảnh');
        $ingredient = Ingredient::findOrFail($id);
        $ingredient->Ten = $req->name;
        if ($ingredient->id_ingredient_type < 3)
            $ingredient->Gia = $req->price;
        else if ($ingredient->id_ingredient_type == 3)
            $ingredient->GiaThanh = $req->price;
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
        Ingredient::findOrFail($id)->delete();
        return back()->with('success', 'Đã xóa');
    }

    public function export()
    {
        return Excel::download(new IngredientExport, 'phu_lieu.xlsx');
    }
}
