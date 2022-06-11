<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Task;


class Assign extends Model
{
    use HasFactory;

    protected $table = 'assigns';

    protected $fillable = ['id_NguoiNhan', 'id_CongViec', 'TrangThai'];

    public $timestamps = false;

    public function reciever(){
        return $this->belongsTo(User::class,'id_NguoiNhan', 'id');
    }

    public function task(){
        return $this->belongsTo(Task::class,'id_CongViec', 'id');
    }
}
