<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FabricDetail extends Model
{
    use HasFactory;

    protected $table = 'fabric_details';

    protected $fillable = ['id_ChiTiet', 'VaiChinh', 'VaiPhu', 'VaiLot'];

    public $timestamps = false;

    public function detail()
    {
        return $this->belongsTo(DetailOrder::class, 'id_ChiTiet', 'id');
    }
}
