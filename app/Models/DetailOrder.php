<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Category;

class DetailOrder extends Model
{
    use HasFactory;

    protected $table = 'chi_tiet_don_hang';

    protected $fillable = [
        'id_DonHang',
        'TenSP', 'LoaiHang',
        'id_DanhMuc', 'id_LoaiVai',
        'id_PhuLieu', 'SoLuong',
        'KichThuoc', 'id_ChatLuong',
        'TongTien', 'TienCoc'
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

    public function fabric()
    {
        return $this->belongsTo(Fabric::class, 'id_LoaiVai', 'id');
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'id_PhuLieu', 'id');
    }

    public function quality()
    {
        return $this->belongsTo(Quality::class, 'id_ChatLuong', 'id');
    }
}
