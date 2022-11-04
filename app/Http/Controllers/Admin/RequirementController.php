<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequestProduction;
use App\Models\WarehouseImport;
use Illuminate\Http\Request;

class RequirementController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:ADMIN,CEO,USER_ACCOUNTANT,USER_SALES,USER_MANAGER');
    }

    public function index(Request $request)
    {
        $requirements = RequestProduction::whereRelation('production_request', 'code', 'like', '%' . $request->keyword . '%')
            ->orWhereRelation('ingredient', 'Ten', 'like', '%' . $request->keyword . '%')
            ->orWhereRelation('ingredient.provider', 'name', 'like', '%' . $request->keyword . '%')
            ->orWhereRelation('ingredient.ingredient_type', 'name', 'like', '%' . $request->keyword . '%')
            ->orderByDesc('id')
            ->paginate(25);
        return view('admin.manage.requirements.index', compact('requirements'));
    }

    public function updateStatus(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|min:1|max:4'
        ]);
        $requestProduction = RequestProduction::findOrFail($id);
        $requestProduction->update([
            'status' => $request->status
        ]);

        if ($request->status == 3) {
            $count = WarehouseImport::count() + 1;
            $code = 'NK' . str_pad($count, 6, '0', STR_PAD_LEFT);
            $dataCreate =  [
                'code' => $code,
                'id_ingredient' => $requestProduction->id_ingredient,
                'type' => 2,
                'id_production' => $requestProduction->id_production,
                'amount' => $requestProduction->amount,
                'note' => 'Nhập kho tự động từ yêu cầu sản xuất ' . $requestProduction->production_request->code,
                'import_date' => \Carbon\Carbon::now()->timezone('Asia/Ho_Chi_Minh')->format('Y-m-d'),
                'id_creator' => auth()->user()->id,
            ];

            WarehouseImport::create($dataCreate);
            return redirect()->route('admin.warehouse.import.index')->with('success', 'Tự động tạo phiếu nhập kho thành công');
        }

        return back()->with('success', 'Cập nhật thành công');
    }
}
