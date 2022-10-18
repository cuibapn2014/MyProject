<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Category;

class DetailOrder extends Model
{
    use HasFactory;

    protected $table = 'detail_orders';

    protected $fillable = [
        'id_DonHang',
        'LoaiHang',
        'amount',
        'id_product',
        'id_ChatLuong',
        'NguonCungCap',
        'image',
        'GhiChu'
    ];

    public $timestamps = true;

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_DonHang', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_DanhMuc', 'id');
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'id_PhuLieu', 'id');
    }

    public function quality()
    {
        return $this->belongsTo(Quality::class, 'id_ChatLuong', 'id');
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Ingredient::class, 'id_product', 'id');
    }

    public function production_request()
    {
        return $this->hasMany(\App\Models\ProductionRequest::class, 'detail_order_id', 'id');
    }
}
