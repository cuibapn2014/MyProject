<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlanIngredient;
use App\Models\Production;
use App\Models\ProductionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    public function store(Request $request, $id_production)
    {
        //
        $planIngredient = PlanIngredient::where('id_production_request', $id_production)->get();
        $exists = Production::where('id_production_request', $id_production);
        $productRequest = ProductionRequest::findOrFail($id_production);
        if ($exists->count() > 0) $exists->delete();
        if (count($planIngredient) <= 0)
            return response()->json(['status' => 'failed', 'msg' => 'Thất bại! Hãy tạo kế hoạch vật tư trước khi tạo lệnh sản xuất'], Response::HTTP_INTERNAL_SERVER_ERROR);
        DB::beginTransaction();
        try {
            foreach ($planIngredient as $plan) {
                if ($plan->ingredient->id_ingredient_type != 1) {
                    $production = Production::create([
                        'code' => 'Creating',
                        'id_product' => $plan->id_ingredient,
                        'id_plan_ingredient' => $plan->id,
                        'id_production_request' => $id_production,
                        'require_total' => $plan->total,
                        'priority' => $productRequest->priority,
                        'creator' => auth()->user()->id
                    ]);
                    $production->code = generateCode($production->id, 'LSX');
                    $production->save();
                }
            }

            $productRequest->status = 2;
            $productRequest->save();

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
        return response()->json(['code' => 200, 'msg' => 'Tạo lệnh sản xuất thành công'], Response::HTTP_OK);
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
