<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\PlanIngredient;
use App\Models\ProductionRequest;
use Illuminate\Http\Request;

class PlanIngredientController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($idProduction)
    {
        PlanIngredient::createData($idProduction);
        return back()->with('success', 'Đã tạo kế hoạch vật tư');
    }
}
