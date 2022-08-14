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
}
