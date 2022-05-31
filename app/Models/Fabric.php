<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fabric extends Model
{
    use HasFactory;

    protected $table = 'loai_vai';

    protected $fillable = ['Ten', 'MauSac', 'TinhChat', 'GhiChu', 'Gia', 'DiaChiMua'];
}
