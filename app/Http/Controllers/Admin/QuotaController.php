<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuotaController extends Controller
{
    //
    public function index()
    {
        return 0;
    }

    public function show($id)
    {
        return Quota::findOrFail($id);
    }

    public function store(Request $request, $id_product)
    {
        $this->validate(
            $request,
            [
                'id_ingredient.0' => 'required',
                'amount.0' => 'min:1'
            ],
            [
                'required' => 'Không được bỏ trống',
                'amount.min' => 'Số lượng ít nhất là 1'
            ]
        );

        DB::beginTransaction();
        try{
            foreach($request->id_ingredient as $key => $ingredient){
                Quota::create([
                    'id_product' => $id_product,
                    'id_ingredient' => $ingredient,
                    'amount' => $request->amount[$key]
                ]);
            }
            DB::commit();
        }catch(\Exception $ex)
        {
            DB::rollback();
            throw $ex;
        }

        return back()->with('success', 'Đã thêm thành công');
        // return response()->json(['msg' => 'success', 'code' => 200]);
    }
}
