<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionRequest extends Model
{
    use HasFactory;

    protected $table = 'production_requests';

    protected $fillable = [
        'detail_order_id',
        'code',
        'id_product',
        'size',
        'color',
        'amount',
        'completed',
        'image',
        'note',
        'status',
        'creator'
    ];

    public function detail_order()
    {
        return $this->belongsTo(\App\Models\DetailOrder::class, 'detail_order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'creator', 'id');
    }

    public function plan_production()
    {
        return $this->hasMany(\App\Models\PlanProduction::class, 'id_production_request', 'id');
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Ingredient::class, 'id_product', 'id');
    }

    public function updateStatus($idProductionRequest)
    {
        $productionRequest = self::findOrFail($idProductionRequest);
        if($productionRequest->amount == $productionRequest->completed){
            $productionRequest->status = 3;
            $productionRequest->save();
        }
    }
}
