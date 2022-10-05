<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produced extends Model
{
    use HasFactory;

    protected $table = 'produceds';

    protected $fillable = [
        'id_production',
        'lot_number',
        'amount',
        'creator',
        'start_date',
        'end_date'
    ];

    public function production()
    {
        return $this->belongsTo(\App\Models\Production::class, 'id_production', 'id');
    }

    public function user_create()
    {
        return $this->belongsTo(\App\Models\User::class, 'creator', 'id');
    }
}
