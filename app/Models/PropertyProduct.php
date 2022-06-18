<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyProduct extends Model
{
    use HasFactory;

    protected $table = 'property_products';

    public $timestamps = false;

    protected $fillable = ['CanNang', 'ChieuCao', 'KichCo', 'id_ChiTiet', 'SoLuong'];
}
