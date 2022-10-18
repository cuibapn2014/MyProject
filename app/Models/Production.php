<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    protected $table = 'productions';

    protected $fillable = [
        'code',
        'id_product',
        'id_plan_ingredient',
        'id_production_request',
        'require_total',
        'priority',
        'status',
        'note',
        'creator',
        'reviewer'
    ];

    public function product()
    {
        return $this->belongsTo(\App\Models\Ingredient::class, 'id_product', 'id');
    }

    public function plan_ingredient()
    {
        return $this->belongsTo(\App\Models\PlanIngredient::class, 'id_plan_ingredient', 'id');
    }

    public function production_request()
    {
        return $this->belongsTo(\App\Models\ProductionRequest::class, 'id_production_request', 'id');
    }

    public function user_create()
    {
        return $this->belongsTo(\App\Models\User::class, 'creator', 'id');
    }

    public function user_review()
    {
        return $this->belongsTo(\App\Models\User::class, 'reviewer', 'id');
    }

    public function produced()
    {
        return $this->hasMany(\App\Models\Produced::class, 'id_production', 'id');
    }
}
