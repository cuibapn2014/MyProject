<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WarehouseImport;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WarehouseImportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $imports = WarehouseImport::with([
            'reviewer',
            'creator',
            'ingredient',
            'ingredient.unit_cal'
        ])->where('code', 'like', '%' . $request->keyword . '%')
            ->orWhereRelation('ingredient', 'Ten', 'like', '%' . $request->keyword . '%')
            ->orWhere('note', 'like', '%' . $request->keyword . '%')
            ->orderBy('status')
            ->orderByDesc('created_at')
            ->paginate(25);
        return response()->json(['code' => 200, 'data' => $imports], Response::HTTP_OK);
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
