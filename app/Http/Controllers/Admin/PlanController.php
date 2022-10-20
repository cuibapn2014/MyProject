<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Http\Requests\PlanRequestUpdate;
use App\Models\Ingredient;
use App\Models\PlanIngredient;
use App\Models\PlanProduction;
use App\Models\PlanProductionDetail;
use App\Models\ProductionRequest;
use App\Models\RequestProduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $plans = PlanProduction::orderByDesc('id')->paginate(25);

        return view('admin.manage.planing.index', compact('plans'));
    }

    public function create($id)
    {
        $production_request = ProductionRequest::findOrFail($id);
        $ingredient = Ingredient::all();

        return view('admin.manage.planing.createPlaning', compact('production_request', 'ingredient'));
    }

    public function store(PlanRequest $request)
    {
        if ($request->validated()) {
            DB::beginTransaction();
            try {
                $plan = new PlanProduction();
                $productRequest = ProductionRequest::findOrFail($request->id_production_request);
                $plan->code = $request->code;
                $plan->id_production_request = $request->id_production_request;
                $plan->name_product = $request->name_product;
                $plan->quota = $request->quota;
                $plan->stage = $request->stage;
                $plan->amount = $request->quota * $productRequest->amount;
                $plan->completed = $productRequest->completed * $plan->quota;
                $plan->priority = $request->priority;
                $plan->note = $request->note;

                $plan->save();

                foreach ($request->id_ingredient as $key => $ingredient) {
                    if ($ingredient != null && $request->ingredient_amount[$key] >= 1) {
                        $planDetail = new PlanProductionDetail();

                        $planDetail->id_plan_production = $plan->id;
                        $planDetail->id_ingredient = $ingredient;
                        $planDetail->id_production_request = $productRequest->id;
                        $planDetail->amount = $request->ingredient_amount[$key];
                        $planDetail->total = $planDetail->amount * ($plan->amount - $plan->completed);

                        $planDetail->save();
                    }
                }
                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                throw $ex;
            }
        }

        return back()->with('success', 'Đã thêm thành công');
    }

    public function edit($id)
    {
        $planProduction = PlanProduction::with(['plan_production_detail', 'plan_production_detail.ingredient'])->findOrFail($id);
        $ingredient = Ingredient::all();

        return view('admin.manage.planing.editPlaning', compact('planProduction', 'ingredient'));
    }

    public function update(PlanRequestUpdate $request, $id)
    {
        if ($request->validated()) {
            DB::beginTransaction();
            try {
                $plan = PlanProduction::findOrFail($id);
                $plan->name_product = $request->name_product;
                $plan->quota = $request->quota;
                $plan->stage = $request->stage;
                $plan->amount = $request->quota * $plan->production_request->amount;
                $plan->completed = $plan->production_request->completed * $plan->quota;
                $plan->priority = $request->priority;
                $plan->note = $request->note;

                $plan->save();

                PlanProductionDetail::where('id_plan_production', $plan->id)->delete();
                foreach ($request->id_ingredient as $key => $ingredient) {
                    if ($ingredient != null && $request->ingredient_amount[$key] >= 1) {
                        $planDetail = new PlanProductionDetail();
                        $planDetail->id_plan_production = $plan->id;
                        $planDetail->id_ingredient = $ingredient;
                        $planDetail->id_production_request = $plan->production_request->id;
                        $planDetail->amount = $request->ingredient_amount[$key];
                        $planDetail->total = $planDetail->amount * ($plan->amount - $plan->completed);

                        $planDetail->save();
                    }
                }
                DB::commit();
                RequestProduction::create($plan->id_production_request);
            } catch (\Exception $ex) {
                DB::rollback();
                throw $ex;
            }
        }
        return redirect()->route('admin.plan.index')->with('success', 'Cập nhật Lệnh sản xuất thành công');
    }

    public function destroy($id)
    {
        $plan = PlanProduction::findOrFail($id);
        PlanProductionDetail::where('id_plan_production', $plan->id)->delete();
        $plan->delete();
        RequestProduction::create($plan->id_production_request);
        return back()->with('success', 'Đã xóa');
    }

    public function createBuy($idRequest)
    {
        $planIngredient = PlanIngredient::where('id_production_request', $idRequest)->get();
        if(count($planIngredient) <= 0) return back()->withErrors(['available' => 'Vui lòng tạo kế hoạch vật tư trước khi tạo yêu cầu mua hàng']);

        $check = ProductionRequest::findOrFail($idRequest);
        if ($check->amount == $check->completed) {
            return back()->withErrors(['available' => 'Không thể tạo yêu cầu mua hàng cho sản phẩm đã hoàn thành']);
        }

        RequestProduction::where('id_production_request', $idRequest)->delete();
        foreach ($planIngredient as $plan) {
            if ($plan->ingredient->ingredient_type->id == 1) {
                $requestProduction = RequestProduction::where('id_production_request', $plan->id_production_request)
                    ->where('id_ingredient', $plan->id_ingredient);

                if (!$requestProduction->exists() && $plan->total > 0) {
                    RequestProduction::create([
                        'id_ingredient' => $plan->id_ingredient,
                        'id_production_request' => $plan->id_production_request,
                        'amount' => $plan->total,
                        'censor' => auth()->user()->id
                    ]);
                } else {
                    $requestProduction = $requestProduction->first();
                    $requestProduction->amount += $plan->total;
                    $requestProduction->save();
                }
            }
        }

        return redirect()->route('admin.requirement.index')->with('success', 'Đã tạo yêu cầu mua hàng');
    }
}