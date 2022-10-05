<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
