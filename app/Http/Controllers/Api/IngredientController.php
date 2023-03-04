<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $type = $request->ingredient_type ?? 1;
        $ingredient = Ingredient::with([
            'provider',
            'provider:id,name,address,phone_number',
            'images',
            'images:id_provide,urlImage',
            'ingredient_type'
        ])->where(function ($query) use ($request) {
            $query->where('Ten', 'like', '%' . $request->keyword . '%')
                ->orWhereRelation('provider', 'name', 'like', '%' . $request->keyword . '%')
                ->orWhereRelation('provider', 'address', 'like', '%' . $request->keyword . '%')
                ->orWhereRelation('provider', 'phone_number', 'like', '%' . $request->keyword . '%')
                ->orWhere('GhiChu', 'like', '%' . $request->keyword . '%')
                ->orWhere('code', 'like', '%' . $request->keyword . '%');
        })
            ->where('id_ingredient_type', $type)
            ->paginate(25);
        return response()->json(['code' => 200, 'data' => $ingredient], Response::HTTP_OK);
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
