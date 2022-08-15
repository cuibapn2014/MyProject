<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductionRequestValidator;
use App\Models\Order;
use App\Models\PlanProduction;
use App\Models\PlanProductionDetail;
use App\Models\ProductionRequest;
use App\Models\RequestProduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $productions = ProductionRequest::orderByDesc('id')->paginate(25);
        return view('admin.manage.production.index', compact('productions'));
    }

    public function create()
    {
        $orders = Order::where('status', 1)->orderByDesc('id')->get();
        return view('admin.manage.production.createProduction', compact('orders'));
    }

    public function store(ProductionRequestValidator $request)
    {
        DB::beginTransaction();
        try {
            $file_name = "";
            $newArr = $request->all();

            if ($request->hasFile('image')) {
                $file = $request->image[0];
                $extension = $file->getClientOriginalExtension();
                $file_name = current(explode('.', $file->getClientOriginalName())) . '_' . time() . '.' . $extension;
                $file->move('img_product', $file_name);
            }

            $newArr['image'] = $file_name;
            $newArr['creator'] = auth()->user()->id;

            ProductionRequest::create($newArr);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
        return redirect()->route('admin.production.index')->with('success', 'Thêm thành công');
    }

    public function edit($id)
    {
        $production = ProductionRequest::findOrFail($id);
        if($production->status > 1){
            // return back();
        }
        $orders = Order::where('status', 1)->orderByDesc('id')->get();
        return view('admin.manage.production.editProduction', compact('production', 'orders'));
    }

    public function update(Request $request, $id)
    {
        $production_request = ProductionRequest::findOrFail($id);
        $requirement = PlanProductionDetail::where('id_production_request', $id)->get();
        DB::beginTransaction();
        try {
            $file_name = "";
            $newArr = $request->all();

            if ($request->hasFile('image')) {
                unlink(public_path('/img_product/' . $production_request->image));
                $file = $request->image[0];
                $extension = $file->getClientOriginalExtension();
                $file_name = current(explode('.', $file->getClientOriginalName())) . '_' . time() . '.' . $extension;
                $newArr['image'] = $file_name;
                $file->move('img_product', $file_name);
            }


            $production_request->update($newArr);

            foreach($requirement as $require){
                $require->total = $require->plan_production->quota * $require->amount * $require->production_request->amount;
                $require->plan_production->amount = $require->plan_production->quota * $require->production_request->amount;
                $require->plan_production->save();
                $require->save();
            }

            // foreach()

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
        return redirect()->route('admin.buy.create', ['id' => $id])->with('success', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        return back()->with('success', 'Đã xóa thành công');
    }

    public function matches($keyword)
    {
        return $keyword;
    }
}
