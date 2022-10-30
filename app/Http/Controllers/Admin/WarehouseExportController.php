<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WarehouseExportRequest;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\Production;
use App\Models\ProductionRequest;
use App\Models\WarehouseExport;
use Illuminate\Http\Request;

class WarehouseExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $exports = WarehouseExport::where('code', 'like', '%'.$request->keyword.'%')
        ->orWhereRelation('ingredient', 'Ten', 'like', '%'.$request->keyword.'%')
        ->orWhere('note', 'like', '%'.$request->keyword.'%')
        ->orderBy('status')
        ->orderByDesc('created_at')
        ->paginate(25);
        return view('admin.manage.export.index', compact('exports'));
    }

    public function create()
    {
        $products = Ingredient::all(); 
        $orders = Order::with(['detail','detail.production_request', 'customer'])->get();
        $productions = Production::all();
        $count = WarehouseExport::count() + 1;
        $code = 'XK'.str_pad($count, 6, '0', STR_PAD_LEFT);
        return view('admin.manage.export.create', compact('products', 'orders', 'productions', 'code'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WarehouseExportRequest $request)
    {
        //
        $dataCreate = $request->all();
        $dataCreate['id_creator'] = auth()->user()->id;
        WarehouseExport::create($dataCreate);
        return redirect()->route('admin.warehouse.export.index')->with('success', 'Thêm thành công');
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

    public function edit($id)
    {
        $products = Ingredient::all(); 
        $orders = Order::with(['detail','detail.production_request', 'customer'])->get();
        $productions = Production::all();
        $export = WarehouseExport::findOrFail($id);
        return view('admin.manage.export.edit', compact('export' ,'products', 'orders', 'productions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WarehouseExportRequest $request, $id)
    {
        //
        $data = $request->all();
        WarehouseExport::findOrFail($id)->update($data);
        return redirect()->route('admin.warehouse.export.index')->with('success', 'Cập nhật thành công');
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

    public function updateStatus($id, $status)
    {
        $export = WarehouseExport::findOrFail($id);
        
        $ingredient = Ingredient::findOrFail($export->id_ingredient);
        if($ingredient->amount < $export->amount) return back()->withErrors(['available' => 'Số lượng tồn kho không đủ với yêu cầu xuất kho']);
        $export->update([
            'status' => $status,
            'id_reviewer' => auth()->user()->id
        ]);
        $ingredient->update([
            'used_amount' => ($ingredient->used_amount - $export->amount) >= 0 ? ($ingredient->used_amount - $export->amount) : 0,
            // 'amount' => $ingredient->amount - $export->amount
        ]);

        return back()->with('success', 'Cập nhật trạng thái thành công');
    }
}
