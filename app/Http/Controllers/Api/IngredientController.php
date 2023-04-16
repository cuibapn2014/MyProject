<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $requestuest)
    {
        //
        $type = $requestuest->type ?? 1;
        $ingredient = Ingredient::with([
            'provider',
            'provider:id,name,address,phone_number',
            'images',
            'images:id_provide,urlImage',
            'ingredient_type'
        ])->where(function ($query) use ($requestuest) {
            $query->where('Ten', 'like', '%' . $requestuest->keyword . '%')
                ->orWhereRelation('provider', 'name', 'like', '%' . $requestuest->keyword . '%')
                ->orWhereRelation('provider', 'address', 'like', '%' . $requestuest->keyword . '%')
                ->orWhereRelation('provider', 'phone_number', 'like', '%' . $requestuest->keyword . '%')
                ->orWhere('GhiChu', 'like', '%' . $requestuest->keyword . '%')
                ->orWhere('code', 'like', '%' . $requestuest->keyword . '%');
        });
        if($type == 1) $ingredient = $ingredient->where('id_ingredient_type', $type);
        else $ingredient = $ingredient->where('id_ingredient_type', '>', 1);
        $ingredient = $ingredient->paginate(25);
        return response()->json(['code' => 200, 'data' => $ingredient], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $requestuest
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                // 'image.*' => 'required',
                'price' => 'integer|nullable'
            ],
            [
                'name.required' => 'Tên Nguyên phụ liệu không được để trống',
                // 'price.required' => 'Giá không được để trống',
                'price.integer' => 'Giá phải là số nguyên',
                // 'image.*.required' => 'Bạn chưa thêm hình ảnh cho Nguyên phụ liệu này',
            ]
        );

        if ($validator->fails())
            return response()->json(['msg' => 'error', 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);

        $ingredient = new Ingredient();
        $ingredient->Ten = $request->name;
        $ingredient->stage = $request->stage ?? 0;
        $ingredient->id_ingredient_type = $request->id_ingredient_type;
        $ingredient->id_unit = $request->id_unit;
        $ingredient->id_provider = $request->provider;
        $ingredient->GhiChu = $request->note;
        $ingredient->code = $request->code;
        $ingredient->Gia = $request->price;

        $ingredient->save();
        if ($request->file('image')) {
            foreach ($request->file('image') as $image) {
                $photo = new Image();
                if ($image != null) {
                    $extension = $image->getClientOriginalExtension();
                    $file_name = current(explode('.', $image->getClientOriginalName())) . '_' . time() . '.' . $extension;
                    $image->move('img', $file_name);
                    $photo->urlImage = $file_name;
                    $photo->type = 'pl';
                    $photo->id_provide = $ingredient->id;      
                }
                else $photo->urlImage = 'placeholder.jpg';
                $photo->save();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $requestuest
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $requestuest, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
