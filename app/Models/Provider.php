<?php

namespace App\Models;

use App\Models\User;
use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $table = 'providers';

    public $timestamps = false;

    protected $fillable = ['name', 'phone_number', 'address', 'note', 'status'];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function ingredients(){
        return $this->hasMany(Ingredient::class, 'id_provider', 'id');
    }
}
