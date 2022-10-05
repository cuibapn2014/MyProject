<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductionRequestValidator;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\ProductionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $product = Ingredient::where('stage', '>', 0)->where('id_ingredient_type', '>', 1)->get();
        return view('admin.manage.production.createProduction', compact('orders', 'product'));
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

            $newArr['image'] = $file_name == '' ? 'placeholder.jpg' : $file_name;
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
        $product = Ingredient::where('stage', '>', 0)->where('id_ingredient_type', '>', 1)->get();

        if ($production->status > 1) {
            return abort(404);
        }

        $orders = Order::where('status', 1)->orderByDesc('id')->get();
        return view('admin.manage.production.editProduction', compact('production', 'orders', 'product'));
    }

    public function update(Request $request, $id)
    {
        $production_request = ProductionRequest::findOrFail($id);
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

    public function updateCompleted(Request $request)
    {
        $requestProduction = ProductionRequest::findOrFail($request->idRequest);
        $maxAmount = Ingredient::findOrFail($request->idIngredient);
   
        $validator = Validator::make($request->all(), [
            'completed' => [
                'min:0',
                function ($attribute, $value, $fail) use ($maxAmount, $requestProduction) {
                    if ($value - $requestProduction->completed > $maxAmount->amount || $value < 0 || $value > $requestProduction->amount) {
                        $fail('Số lượng phân bổ không hợp lệ');
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 500, 'msg' => 'Update failed']);
        }
        
        $calAmount =  $requestProduction->completed - $request->completed;
        $maxAmount->amount += $calAmount;
        $maxAmount->save();

        $requestProduction->completed = $request->completed;
        $requestProduction->save();

        return response()->json(['code' => 200, 'msg' => 'Update success']);
    }
}
