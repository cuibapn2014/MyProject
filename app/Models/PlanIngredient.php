<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanIngredient extends Model
{
    use HasFactory;

    protected $table = 'plan_ingredients';

    protected $fillable = [
        'id_production_request',
        'id_ingredient',
        'total'
    ];

    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class, 'id_order', 'id');
    }

    public function ingredient()
    {
        return $this->belongsTo(\App\Models\Ingredient::class, 'id_ingredient', 'id');
    }

    public static function createData($idProduction)
    {
        $productionRequest = ProductionRequest::findOrFail($idProduction);
        $totalAmount = $productionRequest->amount - $productionRequest->completed;
        $arrParent = [$totalAmount => $productionRequest->id_product];
        $arrChild = [];

        PlanIngredient::where('id_production_request', $idProduction)->delete();

        PlanIngredient::create([
            'id_production_request' => $idProduction,
            'id_ingredient' => $productionRequest->id_product,
            'total' => $totalAmount
        ]);
        
        while(!empty(current($arrParent)))
        {
            $id_ingredient = current($arrParent);
            $total = key($arrParent);
            $product = Ingredient::with('quotas')->find($id_ingredient);
            if(!is_null($product)){
                foreach($product->quotas as $q)
                {
                    PlanIngredient::create([
                        'id_production_request' => $idProduction,
                        'id_ingredient' => $q->ingredient->id,
                        'total' => $total * $q->amount
                    ]);
                    $arrChild[$total * $q->amount] = $q->ingredient->id;                  
                }
            }

            if(empty(next($arrParent))){
                $arrParent = $arrChild;
                $arrChild = [];
            }
        }
    }
}
