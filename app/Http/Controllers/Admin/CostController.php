<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cost;
use Illuminate\Http\Request;

class CostController extends Controller
{
    //
    public function getAll(){
        return response()->json(Cost::all());
    }
}
