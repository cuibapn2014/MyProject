<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function __contruct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.manage.product.product');
    }

    public function create()
    {
        return view('admin.manage.product.createProduct');
    }

    public function store(Request $request)
    {
        return 0;
    }

    public function show($id)
    {
        return 0;
    }

    public function edit($id)
    {
        return 0;
    }

    public function update(Request $request)
    {
        return 0;
    }

    public function destroy($id)
    {
        return $id;
    }
}
