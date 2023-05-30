<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
            'ingredient_type',
            'unit_cal',
            'unit_cal:id,name'
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
        $hasStage = $request->has('stage');

        Validator::extend('exists_name', function($attribute, $value, $parameters) use ($request){
            $exists = Ingredient::where('stage', $request->stage)
            ->where('id_ingredient_type', $request->id_ingredient_type)
            ->where('Ten', 'like', $value)
            ->exists();
            return !$exists;
        });

        $rules = [
            'name' => [
                'required',
                'exists_name',
                // Rule::unique('ingredients', 'Ten')
            ],
            'price' => [
                'regex:/^[+]?[0-9](\.?\d+)*$/',
                'nullable',
                'gte:0'
            ],
            'id_unit_cal' => 'required',
            'id_ingredient_type' => 'required',
        ];

        $messages = [
            'required' => 'Không được bỏ trống',
            'price.integer' => 'Giá phải là số nguyên',
            'name.unique' => 'Tên thành phẩm đã tồn tại',
            'exists_name' => 'Tên đã tồn tại'
        ];

        if($hasStage)
            $rules['stage'] = ['required'];

        $validator = Validator::make($request->all(),$rules, $messages);
        if ($validator->fails())
            return response()->json(['msg' => 'error', 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
            
        $code = Ingredient::generateCode();
        $ingredient = new Ingredient();
        $ingredient->Ten = $request->name;
        $ingredient->stage = $request->stage ?? 0;
        $ingredient->id_ingredient_type = $request->id_ingredient_type;
        $ingredient->id_unit = $request->id_unit_cal;
        $ingredient->id_provider = $request->provider_id;
        $ingredient->GhiChu = $request->note;
        $ingredient->code = $code;
        $ingredient->Gia = $request->price ? str_replace('.','',$request->price) : 0;

        $ingredient->save();
        try{
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
        }catch(\Exception $ex){
            throw $ex;
        }
        return response()->json(['msg' => 'create success', 'data' => $ingredient], Response::HTTP_OK);
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
        $ingredient = Ingredient::with([
            'images',
            'provider',
            'ingredient_type',
            'stage_product',
            'unit_cal'
        ])->findOrFail($id);
        return response()->json(['msg' => 'success', 'data' => $ingredient], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $hasStage = $request->has('stage');

        Validator::extend('exists_name', function($attribute, $value, $parameters) use ($request, $id){
            $exists = Ingredient::where('stage', $request->stage)
            ->where('id_ingredient_type', $request->id_ingredient_type)
            ->where('Ten', 'like', $value)
            ->where('id', '!=', $id)
            ->exists();
            return !$exists;
        });

        $rules = [
            'name' => [
                'required',
                'exists_name',
                // Rule::unique('ingredients', 'Ten')
            ],
            'price' => [
                'regex:/^[+]?[0-9](\.?\d+)*$/',
                'nullable',
                'gte:0'
            ],
            'id_unit_cal' => 'required',
            'id_ingredient_type' => 'required',
        ];

        $messages = [
            'required' => 'Không được bỏ trống',
            'price.integer' => 'Giá phải là số nguyên',
            'name.unique' => 'Tên thành phẩm đã tồn tại',
            'price.integer' => 'Giá phải là số nguyên',
            'exists_name' => 'Tên đã tồn tại'
        ];

        if($hasStage)
            $rules['stage'] = ['required'];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails())
            return response()->json(['msg' => 'error', 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);

        $ingredient = Ingredient::findOrFail($id);
        $ingredient->Ten = $request->name;
        $ingredient->stage = $request->stage ?? 0;
        $ingredient->id_ingredient_type = $request->id_ingredient_type;
        $ingredient->id_unit = $request->id_unit_cal;
        $ingredient->id_provider = $request->provider_id;
        $ingredient->GhiChu = $request->note;
        $ingredient->Gia = $request->price ? str_replace('.','',$request->price) : 0;
        $ingredient->save();

        try{
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
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
        }catch(\Exception $ex){
            throw $ex;
        }
        return response()->json(['msg' => 'create success', 'data' => $ingredient], Response::HTTP_OK);
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
        $ingredient = Ingredient::findOrFail($id);
        $files = Image::where('id_provide', $ingredient->id)->where('type', 'pl');
        foreach($files as $item){
            File::delete(public_path("img/".$item->urlImage));
        }
        $files->delete();
        $ingredient->delete();
        return response()->json(['msg' => 'success'], Response::HTTP_OK);
    }

    /**
     * Search records by term
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function getDataBySelectBox(Request $request){
        $ingredients = Ingredient::where('Ten', 'like', '%'.$request->get('name').'%')
        ->select('id as value', 'Ten as text')
        ->get();
        return response()->json(['code' => 200, 'data' => $ingredients], Response::HTTP_OK);
    }
}
