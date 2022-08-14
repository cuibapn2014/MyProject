<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequestProduction;
use Illuminate\Http\Request;

class RequirementController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $requirements = RequestProduction::orderByDesc('id')->paginate(25);
        return view('admin.manage.requirements.index', compact('requirements'));
    }
}
