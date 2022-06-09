<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Cost;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    //
    public function index()
    {
        return view('admin.home');
    }

    public function getInvoice($id)
    {
        $order = Order::findOrFail($id);
        $costs = Cost::where('id_ChatLuong', $order->detail->id_ChatLuong)->where('id_DanhMuc', $order->detail->id_DanhMuc)->get();
        $quantity = $order->detail->properties->sum('SoLuong');
        $price = 0;
        foreach ($costs as $cost) {
            if ($cost->LimitStart <= $quantity && $cost->LimitFinish >= $quantity) $price = $cost->Gia;
        }
        // $pdf = PDF::loadView('admin.invoice',['order' => $order]);
        // return $pdf->stream('invoice.pdf', array('Attachment'=> 1));         
        return view('admin.invoice', ['order' => $order,'cost' => $price]);
    }

    public function updateImageUser(Request $req, $id)
    {
        $user = User::findOrFail($id);
        $accept = array("png", "jpg", "jpeg", "bmp");
        if ($req->hasFile('image')) {
            $extension = $req->file('image')->getClientOriginalExtension();
            if ($req->file('image') != null && in_array($extension, $accept)) {
                File::delete(public_path("img/user/" . $user->image));
                $file_name = current(explode('.', $req->file('image')->getClientOriginalName())) . '_' . time() . '.' . $extension;
                $req->file('image')->move('img/user/', $file_name);
                $user->image = $file_name;
                $user->save();
            }
        }
        return response()->json($user);
    }

    public function updateUser(Request $req, $id)
    {
        $user = User::with('role')->findOrFail($id);
        $this->validate(
            $req,
            [
                'name' => 'required|min:6',
                'phone' => 'required|numeric|digits:10'
            ],
            [
                'name.min' => 'Tên của bạn ít nhất phải từ 6 ký tự',
                'name.required' => 'Tên của bạn không được để trống',
                'phone.required' => 'Số điện thoại không được để trống',
                'phone.numeric' => 'Số điện thoại không hợp lệ',
                'phone.digits' => 'Số điện thoại không hợp lệ' 
            ]
        );
        $user->name = $req->name;
        $user->phone = $req->phone;
        $user->save();
        
        return response()->json($user);
    }
}
