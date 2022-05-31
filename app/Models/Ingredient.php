<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $table = 'phu_lieu';

    protected $fillable = ['Ten', 'GhiChu', 'HinhAnh'];

    public function images(){
        return $this->hasMany(Image::class, 'id_PhuLieu', 'id');
    }
}
