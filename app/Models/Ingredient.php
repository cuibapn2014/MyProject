<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Provider;

class Ingredient extends Model
{
    use HasFactory;

    protected $table = 'ingredients';

    public $timestamps = false;

    protected $fillable = [
        'Ten', 
        'GhiChu', 
        'HinhAnh',
        'code',
        'amount',
        'used_amount',
        'waste_amount'
    ];

    public function images()
    {
        return $this->hasMany(Image::class, 'id_provide', 'id');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'id_provider', 'id');
    }

    public function unit_cal()
    {
        return $this->belongsTo(\App\Models\UnitCalculate::class, 'id_unit', 'id');
    }

    public function ingredient_type()
    {
        return $this->belongsTo(\App\Models\IngredientType::class, 'id_ingredient_type', 'id');
    }

    public function quotas()
    {
        return $this->hasMany(\App\Models\Quota::class, 'id_product', 'id');
    }

    public function stage_product()
    {
        return $this->belongsTo(\App\Models\StageProduct::class, 'stage', 'id');
    }

    public static function generateCode(){
        $current = self::where('code', 'like', 'NPL%')->orderByDesc('code')->select('code')->first();
        $number = $current ? str_replace("NPL", "", $current->code) : 0;
        $code = "NPL".str_pad(intval($number) + 1, 6, '0', STR_PAD_LEFT);
        return $code;
    }
}
