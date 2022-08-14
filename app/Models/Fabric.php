<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Provider;
class Fabric extends Model
{
    use HasFactory;

    protected $table = 'fabrics';

    protected $fillable = ['Ten', 'MauSac', 'TinhChat', 'GhiChu', 'Gia', 'DiaChiMua'];

    public function images(){
        return $this->hasMany(Image::class, 'id_provide', 'id')->where('type', 'lv');
    }

    public function provider(){
        return $this->belongsTo(Provider::class,'id_provider', 'id');
    }
}
