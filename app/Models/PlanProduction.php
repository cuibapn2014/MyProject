<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanProduction extends Model
{
    use HasFactory;

    protected $table = 'plan_productions';

    public function production_request()
    {
        return $this->belongsTo(\App\Models\ProductionRequest::class, 'id_production_request', 'id');
    }

    public function plan_production_detail()
    {
        return $this->hasMany(\App\Models\PlanProductionDetail::class, 'id_plan_production', 'id');
    }
}
