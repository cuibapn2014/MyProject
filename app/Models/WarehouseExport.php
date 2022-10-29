<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseExport extends Model
{
    use HasFactory;

    protected $table = 'warehouse_exports';

    protected $fillable = [
        'code',
        'id_ingredient',
        'type',
        'id_production',
        'id_order',
        'amount',
        'note',
        'status',
        'export_date',
        'id_creator',
        'id_reviewer'
    ];

    public function ingredient()
    {
        return $this->belongsTo(\App\Models\Ingredient::class, 'id_ingredient', 'id');
    }

    public function production()
    {
        return $this->belongsTo(\App\Models\Production::class, 'id_production', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_creator', 'id');
    }

    public function reviewer()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_reviewer', 'id');
    }

    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class, 'id_order', 'id');
    }
}
