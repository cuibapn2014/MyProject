<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Cost;
use App\Models\Customer;
use App\Models\DetailOrder;
use App\Models\WarehouseExport;
use App\Models\WarehouseImport;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $revenue = Order::selectRaw('sum(paid) as total')->first();
        $countOrder = Order::selectRaw('count(id) as total')->first();
        $countClient = Customer::all();
        $debtSale = Order::selectRaw('sum(total - paid) as debt')
            ->get();
        $debtBuy = WarehouseImport::selectRaw('(sum(price * amount - paid)) as debt')
        ->get();
        $debt = collect(array($debtSale[0], $debtBuy[0]));
        return view('admin.home', compact('revenue', 'countOrder', 'countClient', 'debt'));
    }

    public function getInvoice($id)
    {
        $order = Order::findOrFail($id);
        // $costs = Cost::where('id_ChatLuong', $order->detail->id_ChatLuong)->get();
        $min = 20;
        $price = 0;
        // foreach ($costs as $cost) {
        //     if ($cost->LimitStart <= $quantity && $cost->LimitFinish >= $quantity) $price = $cost->Gia;
        //     else if($quantity < $min && $cost->LimitStart = $min) $price = $cost->Gia; break;
        // }
        // $pdf = PDF::loadView('admin.invoice',['order' => $order,'cost' => $price])->setOptions(['defaultFont' => 'time-new-roman']);
        // return $pdf->stream('invoice.pdf', array('Attachment'=> 1));       
        return view('admin.invoice', ['order' => $order]);
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

    public function getRevenue()
    {
        return Order::selectRaw('month(orders.created_at) as month, sum(paid) as total')
            ->whereYear('orders.created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
    }

    public function countTypeOrder()
    {
        return Order::selectRaw('count(id) as total, status')
        ->where('status',2)
        ->orWhere('status',4)
            ->groupBy('status')
            ->orderBy('status')
            ->get();
    }

    public function getDebt()
    {
        return Order::selectRaw('month(orders.created_at) as month, count(id) as total, count(DISTINCT(id_customer)) as debt')
            ->whereYear('orders.created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
    }
}
