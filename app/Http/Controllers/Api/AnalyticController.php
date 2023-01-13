<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Finance;
use App\Models\Order;
use App\Models\ProductionRequest;
use App\Models\RequestProduction;
use App\Models\WarehouseExport;
use App\Models\WarehouseImport;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AnalyticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $revenue = Order::selectRaw('sum(paid) as total')->first();
        $countOrder = Order::count();
        $countPreOrder = Order::where('status', 1)->count();
        $countClient = Customer::count();
        $debtSale = Order::selectRaw('sum(total - paid) as debt')
            ->get();
        $debtBuy = WarehouseImport::selectRaw('(sum(price * amount - paid)) as debt')
            ->get();
        $debt = array('debtSale' => $debtSale[0]->debt,'debtBuy' => $debtBuy[0]->debt);
        $finance = Finance::where('status', 1)->count();
        $productionRequest = ProductionRequest::where('status', 1)->count();
        $requirement = RequestProduction::where('status', 1)->count();
        $warehouse = WarehouseImport::where('status', 1)->count() + WarehouseExport::where('status', 1)->count();
        $earn = (int) Finance::where('type', 1)->sum('total');
        $spent = (int) Finance::where('type', 2)->sum('total');
        $financeTotal = (object) array('earn' => $earn,'spent' => $spent);
        $orderWarning =  Order::whereDate('NgayTraDon', '<=', now()->addDays(2))
        ->where('NgayTraDon', '>=', now())
        ->count();

        $response = (object) [
            'revenue' => $revenue, 
            'countOrder' => $countOrder, 
            'countClient' => $countClient, 
            'debt' => $debt, 
            'finance' => $finance,
            'productionRequest' => $productionRequest,
            'requirement' => $requirement,
            'warehouse' => $warehouse,
            'countPreOrder' => $countPreOrder,
            'financeTotal' => $financeTotal,
            'orderWarning' => $orderWarning
        ];

        return response()->json(['code' => 200, 'data' => $response], Response::HTTP_OK);
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

    public function getRevenue()
    {
        $revenue = Order::selectRaw('month(orders.created_at) as month, sum(paid) as total')
        ->whereYear('orders.created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();
        return response()->json(['code' => 200, 'data' => $revenue],Response::HTTP_OK);
    }

    public function countTypeOrder()
    {
        $order = Order::selectRaw('count(id) as total, status')
        ->where('status', 2)
        ->orWhere('status', 4)
        ->whereYear('orders.created_at', date('Y'))
        ->groupBy('status')
        ->orderBy('status')
        ->get();
        return response()->json(['code' => 200, 'data' => $order],Response::HTTP_OK);
    }

    public function getDebt()
    {
        $debt = Order::selectRaw('month(orders.created_at) as month, count(id) as total, count(DISTINCT(id_customer)) as debt')
        ->whereYear('orders.created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();
        return response()->json(['code' => 200, 'data' => $debt], Response::HTTP_OK);
    }
}
