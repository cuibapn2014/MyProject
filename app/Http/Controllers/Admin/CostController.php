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
        if ($req->quantity < 20) {
            $cost = Cost::where('id_ChatLuong', $idChatLuong)->where('id_DanhMuc', $idDanhMuc)->first();
            $cost->Gia = $cost->Gia * 1.5;
            return $cost;
        } else {
            foreach (Cost::where('id_ChatLuong', $idChatLuong)->where('id_DanhMuc', $idDanhMuc)->get() as $cost) {
                if ($cost->LimitStart <= $req->quantity && $cost->LimitFinish >= $req->quantity) return $cost;
            }
        }
    }
}
