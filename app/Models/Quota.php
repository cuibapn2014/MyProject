<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quota extends Model
{
    use HasFactory;

    protected $table = 'quotas';

    public $timestamps = false;

    protected $fillable = [
        'id_product',
        'id_ingredient',
        'amount'
    ];

    public function product()
    {
        return $this->belongsTo(\App\Models\Ingredient::class, 'id_product', 'id');
    }

    public function ingredient()
    {
        return $this->belongsTo(\App\Models\Ingredient::class, 'id_ingredient', 'id');
    }

}
