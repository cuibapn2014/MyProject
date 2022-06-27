<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Category;
use App\Models\PropertyProduct;
use App\Models\FabricDetail;
use App\Models\IngredientDetail;

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
        'TongTien', 'TienCoc', 'Gia',
        'NguonCungCap', 'image',
        'VaiChinh', 'VaiPhu', 'VaiLot',
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

    public function fabric_main()
    {
        return $this->belongsTo(Fabric::class, 'VaiChinh', 'id');
    }

    public function fabric_extra()
    {
        return $this->belongsTo(Fabric::class, 'VaiPhu', 'id');
    }

    public function fabric_lining()
    {
        return $this->belongsTo(Fabric::class, 'VaiLot', 'id');
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'id_PhuLieu', 'id');
    }

    public function quality()
    {
        return $this->belongsTo(Quality::class, 'id_ChatLuong', 'id');
    }

    public function properties()
    {
        return $this->hasMany(PropertyProduct::class, 'id_ChiTiet', 'id');
    }

    public function fabric_detail()
    {
        return $this->hasOne(FabricDetail::class, 'id_ChiTiet', 'id');
    }

    public function ingredient_details()
    {
        return $this->hasMany(IngredientDetail::class, 'id_ChiTiet', 'id');
    }
}
