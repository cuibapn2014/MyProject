<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlanIngredient;
use App\Models\Produced;
use App\Models\Production;
use App\Models\ProductionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProducedController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Produced::all();
    }

    public function show($id)
    {
        return Produced::findOrFail($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, 
        [
            'id_production' => 'required|exists:productions,id',
            'lot_number' => 'required',
            'amount' => 'numeric|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ],
        [
            'required' => 'Giá trị không được trống',
            'numeric' => 'Giá trị phải là số nguyên',
            'min' => 'Giá trị tối thiểu là 1',
            'date' => 'Định dạng ngày không hợp lệ',
            'after' => 'Giá trị nhập không hợp lệ'
        ]);
        
        $idProduction = $request->id_production;
        $production = Production::findOrFail($idProduction);
        $productionRequest = ProductionRequest::findOrFail($production->id_production_request);
        $producedTotal = Produced::where('id_production', $idProduction)->get();
        $total = $producedTotal->sum('amount') + $request->amount;
        if($total > $production->require_total)
        return back()->withErrors(['amount' => 'Số lượng không hợp lệ']);

        DB::beginTransaction();
        try{
            $data = $request->all();
            $data['creator'] = auth()->user()->id;
            Produced::create($data);
            PlanIngredient::createData($productionRequest->id);
            if($production->id_product == $productionRequest->id_product){
                $productionRequest->completed += $total;
                $productionRequest->save();
                $productionRequest->updateStatus($productionRequest->id);
            }

            DB::commit(); 
        }catch(\Exception $ex){
            DB::rollback();
            throw $ex;
        }

        return back()->with('success', 'Đã cập nhật số lượng sản xuất');
    }
}
