<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'name', 
        'phone_number', 
        'address', 
        'note', 
        'creator'
    ];

    public function orders(){
        return $this->hasMany(\App\Models\Order::class, 'SoDienThoai', 'phone_number');
    }

    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'creator', 'id');
    }
}
