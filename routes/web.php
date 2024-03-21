<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CostController;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductionRequestController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\ProviderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\PlanIngredientController;
use App\Http\Controllers\Admin\ProducedController;
use App\Http\Controllers\Admin\ProductionController;
use App\Http\Controllers\Admin\QuotaController;
use App\Http\Controllers\Admin\RequirementController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\WarehouseExportController;
use App\Http\Controllers\Admin\WarehouseImportController;
use App\Http\Controllers\Auth\ChangePasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('{any}', function() {
    return view('home');
})->where('any', '(.*)');
