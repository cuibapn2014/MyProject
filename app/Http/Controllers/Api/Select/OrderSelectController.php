<?php

namespace App\Http\Controllers\Api\Select;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class OrderSelectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $orders = Order::with(['customer'])
            ->leftJoin('customers', 'id_customer', 'customers.id')->where('orders.code', 'like', '%' . $request->name . '%')
            ->leftJoin('detail_orders', 'orders.id', 'detail_orders.id_DonHang')
            ->leftJoin('ingredients', 'ingredients.id', 'detail_orders.id_product')
            ->orWhereHas('customer', function($query) use ($request){
                $query->where('name', 'like', '%'.$request->name.'%');
            })
            ->orderBy('orders.code')
            ->selectRaw('CONCAT(orders.code, " - ", ingredients.Ten, " - KH: ", customers.name) AS text, detail_orders.id AS value')
            ->get()
            ->toArray();
        $orders[] = (object) ['text' => 'Lưu kho', 'value' => 0];
        $orders = array_reverse($orders);
        return response()->json(['code' => 200, 'data' => $orders], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
