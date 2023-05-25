<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Production;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $productions = Production::with([
            'product',
            'product.unit_cal',
            'product.ingredient_type',
            'product.stage_product',
            'plan_ingredient',
            'production_request',
            'produceds',
            'user_review',
            'user_create'
        ])->where('code', 'like', '%' . $request->keyword . '%')
            ->orWhereRelation('production_request', 'code', 'like', '%' . $request->keyword . '%')
            ->orWhereRelation('product', 'Ten', 'like', '%' . $request->keyword . '%')
            ->orWhereRelation('product.stage_product', 'name', 'like', '%' . $request->keyword . '%')
            ->orderByDesc('id')
            ->orderByDesc('priority')
            ->paginate(25);

        return response()->json(['code' => 200, 'data' => $productions], Response::HTTP_OK);
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