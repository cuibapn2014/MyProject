<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Quota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class QuotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $id_product = $request->get('id_product', 0);
        $product = Ingredient::find($id_product);
        $ingredients = Ingredient::select('id as value', 'Ten as text')->get();
        $results = Quota::with([
            'product:id,Ten',
            'ingredient:id,Ten'
        ])->where('id_product', $id_product)->get();
        return response()->json([
            'msg' => 'success', 
            'data' => $results, 
            'product' => $product,
            'ingredients' => $ingredients
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules = [
            // 'id_ingredient.0' => 'required',
            'amount.*' => 'nullable|min:1',
            'id_product' => 'exists:ingredients,id'
        ];

        $messages = [
            'required' => 'Không được bỏ trống',
            'amount.*.min' => 'Số lượng ít nhất là 1',
            'id_product' => 'Thành phẩm không tồn tại'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails())
            return response()->json(['msg' => 'error', 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);

        try{
            $id_product = $request->get('id_product');
            Quota::where('id_product', $id_product)->delete();
            $list = $request->id_ingredient ?? [];
            foreach($list as $key => $ingredient){
                if(!$ingredient || !$request->amount[$key]) continue;
                Quota::create([
                    'id_product' => $id_product,
                    'id_ingredient' => $ingredient,
                    'amount' => $request->amount[$key]
                ]);
            }
        }catch(\Exception $ex){
            throw $ex;
        }
  
        return response()->json(['msg' => 'success'], Response::HTTP_OK);
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
