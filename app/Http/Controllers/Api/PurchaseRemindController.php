<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RequestProduction;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PurchaseRemindController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $purchases = RequestProduction::with([
            'ingredient',
            'ingredient.unit_cal',
            'ingredient.ingredient_type',
            'ingredient.provider',
            'production_request',
            'user'
        ])->whereRelation('production_request', 'code', 'like', '%' . $request->keyword . '%')
            ->orWhereRelation('ingredient', 'Ten', 'like', '%' . $request->keyword . '%')
            ->orWhereRelation('ingredient.provider', 'name', 'like', '%' . $request->keyword . '%')
            ->orWhereRelation('ingredient.ingredient_type', 'name', 'like', '%' . $request->keyword . '%')
            ->orderByDesc('id')
            ->paginate(25);

        return response()->json(['code' => 200, 'data' => $purchases], Response::HTTP_OK);
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
