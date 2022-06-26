<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientDetail extends Model
{
    use HasFactory;

    protected $table = "ingredient_details";

    public $timestamps = false;

    protected $fillable = ['id_ChiTiet', 'id_PhuLieu', 'SoLuong'];

    public function detail(){
        return $this->belongsTo(DetailOrder::class, 'id_ChiTiet', 'id');
    }

    public function ingredient(){
        return $this->belongsTo(Ingredient::class, 'id_PhuLieu', 'id');
    }
}
