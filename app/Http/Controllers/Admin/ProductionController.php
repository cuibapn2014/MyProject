<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlanIngredient;
use App\Models\Production;
use App\Models\ProductionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $plans = Production::orderByDesc('id')->orderByDesc('priority')->paginate(25);

        return view('admin.manage.planing.index', compact('plans'));
    }

    public function create($idProduction)
    {
        $planIngredient = PlanIngredient::where('id_production_request', $idProduction)->get();
        $count = Production::distinct('id_production_request')->count();
        $code = 'LSX' . str_pad(($count + 1), 6, '0', STR_PAD_LEFT);
        $exists = Production::where('id_production_request', $idProduction);
        $productRequest = ProductionRequest::findOrFail($idProduction);
        if($exists->count() > 0) $exists->delete();
        if(count($planIngredient) <= 0)
            return response()->json(['code' => 500, 'status' => 'failed','msg' => 'Thất bại! Hãy tạo kế hoạch vật tư trước khi tạo lệnh sản xuất']);
        DB::beginTransaction();
        try {        
            foreach ($planIngredient as $plan) {
                if ($plan->ingredient->id_ingredient_type != 1) {
                    Production::create([
                        'code' => $code,
                        'id_product' => $plan->id_ingredient,
                        'id_plan_ingredient' => $plan->id,
                        'id_production_request' => $idProduction,
                        'require_total' => $plan->total,
                        'priority' => $productRequest->priority,
                        'creator' => auth()->user()->id
                    ]);
                }
            }

            $productRequest->status = 2;
            $productRequest->save();

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }

        return response()->json(['code' => 200, 'status' => 'success', 'msg' => 'Tạo lệnh sản xuất thành công']);
    }

    public function updateStatus(Request $req, $id)
    {
        $productRequest = ProductionRequest::findOrFail($id);
        $productRequest->update([
            'status' => $req->status
        ]);
        return back()->with('success', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        return $id;
    }
}
