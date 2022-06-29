<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Cost;
use App\Models\DetailOrder;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    //
    public function index()
    {
        $revenue = DetailOrder::selectRaw('sum(TienCoc + ThanhToanBS) as total')->first();
        $countOrder = Order::selectRaw('count(id) as total')->first();
        $countClient = Order::selectRaw('count(id) as total, SoDienThoai')
        ->groupBy('SoDienThoai')
        ->get();
        $debt = Order::selectRaw('sum(don_hang.TongTien - chi_tiet_don_hang.TienCoc - chi_tiet_don_hang.ThanhToanBS) as debt')
        ->join('chi_tiet_don_hang', 'don_hang.id', '=', 'chi_tiet_don_hang.id_DonHang')
        ->get();
        return view('admin.home',['revenue' => $revenue,'countOrder' => $countOrder,'countClient' => $countClient,'debt' => $debt]);
    }

    public function getInvoice($id)
    {
        $order = Order::findOrFail($id);
        $costs = Cost::where('id_ChatLuong', $order->detail->id_ChatLuong)->where('id_DanhMuc', $order->detail->id_DanhMuc)->get();
        $quantity = $order->detail->properties->sum('SoLuong');
        $min = 20;
        $price = 0;
        foreach ($costs as $cost) {
            if ($cost->LimitStart <= $quantity && $cost->LimitFinish >= $quantity) $price = $cost->Gia;
            else if($quantity < $min && $cost->LimitStart = $min) $price = $cost->Gia; break;
        }
        // $pdf = PDF::loadView('admin.invoice',['order' => $order,'cost' => $price])->setOptions(['defaultFont' => 'time-new-roman']);
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

    public function getRevenue(){
        return Order::selectRaw('month(don_hang.created_at) as month, (chi_tiet_don_hang.TienCoc + chi_tiet_don_hang.ThanhToanBS) as total')
        ->join('chi_tiet_don_hang', 'don_hang.id', '=', 'chi_tiet_don_hang.id_DonHang')
        ->whereYear('don_hang.created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month','asc')
        ->get();
    }

    public function countTypeOrder(){
        return DetailOrder::selectRaw('count(id) as total, LoaiHang')
        ->groupBy('LoaiHang')
        ->get();
    }

    public function getDebt(){
        return Order::selectRaw('month(don_hang.created_at) as month, sum(don_hang.TongTien) as total, sum(don_hang.TongTien - chi_tiet_don_hang.TienCoc - chi_tiet_don_hang.ThanhToanBS) as debt')
        ->join('chi_tiet_don_hang', 'don_hang.id', '=', 'chi_tiet_don_hang.id_DonHang')
        ->whereYear('don_hang.created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month','asc')
        ->get();
    }
}
