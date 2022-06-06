<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use PDF;

class AdminController extends Controller
{
    //
    public function index(){
        return view('admin.home');
    }

    public function getInvoice($id){
        $order = Order::findOrFail($id);
        // $pdf = PDF::loadView('admin.invoice',['order' => $order]);
        // return $pdf->stream('invoice.pdf', array('Attachment'=>0));         
        return view('admin.invoice',['order' => $order]);
    }
}
