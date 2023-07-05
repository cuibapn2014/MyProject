<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlanIngredient;
use App\Models\ProductionRequest;
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

    /**
     * Create request purchase
     * @param int $id_request
     * @return \Illuminate\Http\Response
     * */
    public function createPurchase($id_request)
    {
        $planIngredient = PlanIngredient::where('id_production_request', $id_request)->get();
        // if(count($planIngredient) <= 0) return back()->withErrors(['available' => 'Vui lòng tạo kế hoạch vật tư trước khi tạo yêu cầu mua hàng']);

        $check = ProductionRequest::findOrFail($id_request);
        if ($check->amount == $check->completed) {
            // return back()->withErrors(['available' => 'Không thể tạo yêu cầu mua hàng cho sản phẩm đã hoàn thành']);
            return response()->json(['msg' => 'error', 'errors' => (object)['available' => 'Không thể tạo yếu cầu mua hàng cho đề nghị sản xuất đã hoàn thành']], Response::HTTP_BAD_REQUEST);
        }

        RequestProduction::where('id_production_request', $id_request)->delete();
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

        return response()->json(['msg' => 'Tạo yêu cầu mua hàng thành công'], Response::HTTP_OK);
    }
}
