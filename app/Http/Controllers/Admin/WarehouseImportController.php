<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WarehouseImportRequest;
use App\Models\Ingredient;
use App\Models\WarehouseImport;
use Illuminate\Http\Request;

class WarehouseImportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
        $imports = WarehouseImport::orderBy('status')->orderByDesc('created_at')->paginate(25);
        return view('admin.manage.import.index', compact('imports'));
    }

    public function create()
    {
        $products = Ingredient::orderBy('id_ingredient_type')->get();
        $count = WarehouseImport::count() + 1;
        $code = 'NK'.str_pad($count, 6, '0', STR_PAD_LEFT);
        return view('admin.manage.import.create', compact('products', 'code'));
    }

    public function store(WarehouseImportRequest $request)
    {
        //
        $create_data = $request->all();
        $create_data['id_creator'] = auth()->user()->id;
        WarehouseImport::create($create_data);
        return redirect()->route('admin.warehouse.import.index')->with('success', 'Tạo mới thành công');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $import = WarehouseImport::findOrFail($id);
        $products = Ingredient::orderBy('id_ingredient_type')->get();
        return view('admin.manage.import.edit', compact('import', 'products'));
    }

    public function update(WarehouseImportRequest $request, $id)
    {
        //
        $dataUpdate = $request->all();
        $dataUpdate['is_pay'] = ($dataUpdate['is_pay'] ?? false) ? 2 : 1;
        WarehouseImport::findOrFail($id)->update($dataUpdate);
        return redirect()->route('admin.warehouse.import.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        //
    }

    public function updateStatus($id, $status)
    {
        $import = WarehouseImport::findOrFail($id);

        $import->update([
            'status' => $status,
            'id_reviewer' => auth()->user()->id
        ]);

        $ingredient = Ingredient::findOrFail($import->id_ingredient);
        switch($import->type)
        {
            case 1: 
                $ingredient->update([
                    'amount' => $ingredient->amount + $import->amount
                ])
                ;break;
            case 2: 
                $ingredient->update([
                    'amount' => $ingredient->amount + $import->amount,
                    'used_amount' => $ingredient->used_amount + $import->amount
                ])
                ;break;
            case 3: 
                $ingredient->update([
                    'waste_amount' => $ingredient->waste_amount + $import->amount
                ])
                ;break;
        }

        return back()->with('success', 'Cập nhật trạng thái thành công');
    }
}
