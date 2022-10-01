<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StageProduct extends Model
{
    use HasFactory;

    protected $table = 'stage_products';

    public $timestamps = false;

    protected $fillable = ['name'];
}
