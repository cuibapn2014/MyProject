<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cost;
use Illuminate\Http\Request;

class CostController extends Controller
{
    //
    public function getAll()
    {
        return response()->json(Cost::all());
    }

    public function getCost(Request $req, $idChatLuong, $idDanhMuc)
    {
        foreach (Cost::where('id_ChatLuong', $idChatLuong)->where('id_DanhMuc', $idDanhMuc)->get() as $cost) {
            if ($cost->LimitStart <= $req->quantity && $cost->LimitFinish >= $req->quantity) return $cost;
        }

        return null;
    }
}
