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
        $priority = ProductionRequest::findOrFail($idProduction)->priority;
        if($exists->count() > 0) $exists->delete();

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
                        'priority' => $priority,
                        'creator' => auth()->user()->id
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }

        return response()->json(['code' => 200, 'msg' => 'success']);
    }

    public function updateStatus($id)
    {
        return $id;
    }

    public function destroy($id)
    {
        return $id;
    }
}
