<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Assign;
use App\Models\User;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    public $timestampt = true;

    protected $fillable = [
        'id_nguoi_giao',
        'tieu_de',
        'chi_tiet',
        'TienDo',
        'ngay_hoan_thanh'
    ];

    public function assigns()
    {
        return $this->hasMany(Assign::class, 'id_CongViec', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_nguoi_giao', 'id');
    }
}
