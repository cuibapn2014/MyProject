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

    protected $table = 'orders';

    protected $fillable = [
        'code',
        'id_customer',
        'NgayTraDon',
        'id_NhanVien',
        'vat',
        'total',
        'paid',
        'status',
        'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_NhanVien', 'id');
    }

    public function detail()
    {
        return $this->hasMany(DetailOrder::class, 'id_DonHang', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class, 'id_customer', 'id');
    }

    public function export_details()
    {
        return $this->hasMany(\App\Models\WarehouseExport::class,'id_order', 'id');
    }

    public static function totalPaid($idOrder)
    {
        $total = 0;
        $order = parent::findOrFail($idOrder);
        foreach($order->detail as $detail){
            $total += $detail->amount * $detail->price;
        }
        return $total;
    }
}
