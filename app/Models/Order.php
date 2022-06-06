<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\DetailOrder;
use App\Models\Image;

class Order extends Model
{
    use HasFactory;

    protected $table = 'don_hang';

    protected $fillable = ['TenKhachHang', 'SoDienThoai', 'DiaChi', 'NgayTraDon'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_NhanVien', 'id');
    }

    public function detail(){
        return $this->hasOne(DetailOrder::class,'id_DonHang','id');
    }
}
