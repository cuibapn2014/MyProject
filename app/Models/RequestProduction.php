<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestProduction extends Model
{
    use HasFactory;

    protected $table = 'request_productions';

    protected $fillable = ['id_ingredient','amount', 'status', 'id_production_request'];

    public $timestamps = true;

    public function ingredient()
    {
        return $this->belongsTo(\App\Models\Ingredient::class, 'id_ingredient', 'id');
    }

    public function production_request()
    {
        return $this->belongsTo(\App\Models\ProductionRequest::class, 'id_production_request', 'id');
    }

    public static function create($idRequest)
    {
        $planProduct = PlanProductionDetail::where('id_production_request', $idRequest)
            ->selectRaw('sum(total) as sum_total, id_ingredient, id_production_request')
            ->where('total', '>', 0)
            ->groupBy('id_ingredient', 'id_production_request')
            ->get();

        $check = ProductionRequest::findOrFail($idRequest);
        if ($check->amount == $check->completed) {
            return back()->withErrors(['available' => 'Không thể tạo yêu cầu mua hàng cho sản phẩm đã hoàn thành']);
        }

        RequestProduction::where('id_production_request', $idRequest)->delete();
        foreach ($planProduct as $plan) {
            $ingredient = Ingredient::find($plan->id_ingredient);
            if ($plan->sum_total > $ingredient->amount) {
                $requestProduction = new RequestProduction();
                $countBuy = RequestProduction::where('id_ingredient', $plan->id_ingredient)
                    ->where('status', '1')
                    ->sum('amount');
                $requestProduction->id_ingredient = $plan->id_ingredient;
                $requestProduction->amount = !$countBuy ? $plan->sum_total - $ingredient->amount : $plan->sum_total;
                $requestProduction->id_production_request = $plan->id_production_request;
                $requestProduction->save();
            }
        }
    }
}
