<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'don_hang';

    protected $fillable = ['TenKhachHang', 'SoDienThoai', 'DiaChi', 'NgayTraDon'];

}
