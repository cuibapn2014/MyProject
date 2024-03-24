<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    use HasFactory;

    protected $table = 'finances';

    protected $fillable = [
        'code',
        'type',
        'title',
        'detail', 
        'total',
        'id_user',
        'status',
        'reviewer_date',
        'create_date'
    ];

    protected $casts = [
        'status' => 'integer',
        'total' => 'biginteger'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
