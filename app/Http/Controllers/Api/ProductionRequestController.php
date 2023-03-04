<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductionRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductionRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $productions = ProductionRequest::with([
            'user',
            'user:id,name,image,id_role',
            'user.role:id,name',
            'product',
            'product.images'
        ])->where('code', 'like', '%'.$request->keyword.'%')
        ->orWhere('size', 'like', '%'.$request->keyword.'%')
        ->orWhere('color', 'like', '%'.$request->keyword.'%')
        ->orWhereRelation('product', 'Ten', 'like', '%'.$request->keyword.'%')
        ->orderByDesc('id')
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
