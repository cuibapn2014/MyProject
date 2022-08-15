<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanProductionDetail extends Model
{
    use HasFactory;

    protected $table = 'plan_production_details';

    public $timestamps = false;

    public function plan_production()
    {
        return $this->belongsTo(\App\Models\PlanProduction::class, 'id_plan_production', 'id');
    }

    public function ingredient()
    {
        return $this->belongsTo(\App\Models\Ingredient::class, 'id_ingredient', 'id');
    }

    public function production_request()
    {
        return $this->belongsTo(\App\Models\ProductionRequest::class, 'id_production_request', 'id');
    }
}
