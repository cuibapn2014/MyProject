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

// Auth::routes();

// Route::get('/', function () {
//     return view('home');
//     return redirect()->route('admin.home');
// })->name('home');

Route::get('{any}', function() {
    return view('home');
})->where('any', '(.*)');

// Register
// Route::get('/register', [AuthController::class, 'getRegister'])->name('register');
// Route::post('/register', [AuthController::class, 'register'])->name('request.register');


// Login
// Route::get('/login', [AuthController::class, 'index'])->name('login');
// Route::post('/login', [AuthController::class, 'login'])->name('request.login');

// Logout
// Route::get('/logout', function (Request $request) {
//     if (Auth::check()) {
//         Auth::logout();
//         $request->session()->invalidate();
//         $request->session()->regenerateToken();
//         return redirect()->route('home');
//     }

//     return redirect()->route('login');
// })->middleware('auth')->name('logout');

//Forgot password
// Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot');
// Route::post('/forgot-password', [AuthController::class, 'postForgotPassword'])->name('auth.forgot.request');
// Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');
// Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('auth.password.update');

//Change password
// Route::post('/change-password', [ChangePasswordController::class, 'changePassword'])->name('auth.password.request.change');

//Admin Route
// Route::group(['prefix' => 'admin', 'middleware' => 'user'], function ($route) {
//     $route->get('/', [AdminController::class, 'index'])->name('admin.home');

//     $route->group(['prefix' => 'customer'], function ($route) {
//         $route->get('/', [CustomerController::class, 'index'])->name('admin.customer.index');
//         // $route->get('/all', [CustomerController::class, 'findByAll'])->name('admin.customer.getAll');
//         $route->get('/create', [CustomerController::class, 'create'])->name('admin.customer.create');
//         $route->post('/create', [CustomerController::class, 'store'])->name('admin.customer.request.create');
//         $route->get('/update/{id}', [CustomerController::class, 'edit'])->name('admin.customer.update');
//         $route->post('/update/{id}', [CustomerController::class, 'update'])->name('admin.customer.request.update');
//         $route->get('/delete/{id}', [CustomerController::class, 'destroy'])->name('admin.customer.delete');
//         // $route->get('/export', [CustomerController::class, 'export'])->name('admin.fabric.export');
//     });

//     $route->group(['prefix' => 'provider'], function ($route) {
//         $route->get('/', [ProviderController::class, 'index'])->name('admin.provider.index');
//         $route->get('/all', [ProviderController::class, 'findByAll'])->name('admin.provider.getAll');
//         $route->get('/create', [ProviderController::class, 'create'])->name('admin.provider.create');
//         $route->post('/create', [ProviderController::class, 'store'])->name('admin.provider.request.create');
//         $route->get('/update/{id}', [ProviderController::class, 'edit'])->name('admin.provider.update');
//         $route->post('/update/{id}', [ProviderController::class, 'update'])->name('admin.provider.request.update');
//         $route->get('/delete/{id}', [ProviderController::class, 'destroy'])->name('admin.provider.delete');
//         // $route->get('/export', [ProviderController::class, 'export'])->name('admin.fabric.export');
//     });

//     $route->group(['prefix' => 'ingredient'], function ($route) {
//         $route->get('/', [IngredientController::class, 'index'])->name('admin.ingredient.index');
//         $route->get('/create', [IngredientController::class, 'getStore'])->name('admin.ingredient.create');
//         $route->post('/create', [IngredientController::class, 'store'])->name('admin.ingredient.request.create');
//         $route->get('/update/{id}', [IngredientController::class, 'getUpdate'])->name('admin.ingredient.update');
//         $route->post('/update/{id}', [IngredientController::class, 'update'])->name('admin.ingredient.request.update');
//         $route->get('/delete/{id}', [IngredientController::class, 'delete'])->name('admin.ingredient.delete');
//         $route->get('/export', [IngredientController::class, 'export'])->name('admin.ingredient.export');
//     });

//     $route->get('/products', [IngredientController::class, 'getAllProduct'])->name('admin.product.index');
//     // Gợi ý phát triển ở Module bán hàng
//     // $route->group(['prefix' => 'product'], function ($route) {
//     //     $route->get('/', [ProductController::class, 'index'])->name('admin.product.index');
//     //     $route->get('/create', [ProductController::class, 'create'])->name('admin.product.create');
//     //     $route->post('/create', [ProductController::class, 'store'])->name('admin.product.request.create');
//     //     $route->get('/update/{id}', [ProductController::class, 'edit'])->name('admin.product.update');
//     //     $route->post('/update/{id}', [ProductController::class, 'update'])->name('admin.product.request.update');
//     //     $route->get('/delete/{id}', [ProductController::class, 'delete'])->name('admin.product.delete');
//     //     // $route->get('/export', [ProductController::class, 'export'])->name('admin.product.export');
//     // });


//     $route->group(['prefix' => 'order','middleware' => 'role:ADMIN,CEO,USER_SALES,USER_MANAGER'], function ($route) {
//         $route->get('/', [OrderController::class, 'index'])->name('admin.order.index');
//         $route->get('/create', [OrderController::class, 'create'])->name('admin.order.create');
//         $route->post('/create', [OrderController::class, 'store'])->name('admin.order.request.create');
//         $route->get('/update/{id}', [OrderController::class, 'edit'])->name('admin.order.update');
//         $route->get('/getEdit/{id}', [OrderController::class, 'getDataEdit'])->name('admin.order.dataDetail');
//         $route->post('/update/{id}', [OrderController::class, 'update'])->name('admin.order.request.update');
//         $route->get('/delete/{id}', [OrderController::class, 'delete'])->name('admin.order.delete');
//         $route->get('/export', [OrderController::class, 'export'])->name('admin.order.export');
//         $route->get('/update/{id}/{status}', [OrderController::class, 'updateStatus'])->name('admin.order.updateStatus');
//     });

//     $route->group(['prefix' => 'task'], function ($route) {
//         $route->get('/', [TaskController::class, 'index'])->name('admin.task.index');
//         $route->get('/user', [TaskController::class, 'getListTask'])->name('admin.task.user.index');
//         $route->get('/get', [TaskController::class, 'getByUser'])->name('admin.task.user.get');
//         $route->get('/create', [TaskController::class, 'create'])->name('admin.task.create');
//         $route->post('/create', [TaskController::class, 'store'])->name('admin.task.request.create');
//         $route->get('/update/{id}', [TaskController::class, 'edit'])->name('admin.task.update');
//         $route->post('/update/{id}', [TaskController::class, 'update'])->name('admin.task.request.update');
//         $route->get('/delete/{id}', [TaskController::class, 'delete'])->name('admin.task.delete');
//     });

//     $route->group(['prefix' => 'production'], function ($route) {
//         $route->get('/', [ProductionRequestController::class, 'index'])->name('admin.production.index');
//         $route->get('/create', [ProductionRequestController::class, 'create'])->name('admin.production.create');
//         $route->post('/create', [ProductionRequestController::class, 'store'])->name('admin.production.request.create');
//         $route->get('/update/{id}', [ProductionRequestController::class, 'edit'])->name('admin.production.update');
//         $route->post('/update/{id}', [ProductionRequestController::class, 'update'])->name('admin.production.request.update');
//         $route->get('/delete/{id}', [ProductionRequestController::class, 'destroy'])->name('admin.production.delete');
//         $route->post('/update-completed', [ProductionRequestController::class, 'updateCompleted'])->name('admin.productionCompleted.request.update');
//         $route->get('/export', [ProductionRequestController::class, 'export'])->name('admin.production.export');
//     });

//     $route->group(['prefix' => 'plan'], function ($route) {
//         $route->get('/', [ProductionController::class, 'index'])->name('admin.plan.index');
//         $route->get('/create/{id}', [ProductionController::class, 'create'])->name('admin.plan.create');
//         $route->post('/create', [ProductionController::class, 'store'])->name('admin.plan.request.create');
//         $route->get('/update/{id}', [ProductionController::class, 'edit'])->name('admin.plan.update');
//         $route->get('/update-status/{id}', [ProductionController::class, 'updateStatus'])->name('admin.plan.updateStatus');
//         $route->post('/update-completed', [ProducedController::class, 'store'])->name('admin.plan.request.update');
//         $route->get('/delete/{id}', [ProductionController::class, 'destroy'])->name('admin.plan.delete');
//         $route->get('/create-buy/{id}', [PlanController::class, 'createBuy'])->name('admin.buy.create');
//         $route->get('/export', [ProductionController::class, 'export'])->name('admin.plan.export');
//     });

//     $route->group(['prefix' => 'warehouse', 'middleware' => 'role:ADMIN,CEO,STOREKEEPER,USER_ACCOUNTANT,USER_MANAGER'], function ($route) {
//         $route->group(['prefix' => 'imports'], function ($route) {
//             $route->get('/', [WarehouseImportController::class, 'index'])->name('admin.warehouse.import.index');
//             $route->get('/create', [WarehouseImportController::class, 'create'])->name('admin.warehouse.import.create');
//             $route->post('/create', [WarehouseImportController::class, 'store'])->name('admin.warehouse.import.store');
//             $route->get('/update/{id}', [WarehouseImportController::class, 'edit'])->name('admin.warehouse.import.edit');
//             $route->post('/update/{id}', [WarehouseImportController::class, 'update'])->name('admin.warehouse.import.update');
//             $route->get('/update-status/{id}/{status}', [WarehouseImportController::class, 'updateStatus'])->name('admin.warehouse.import.updateStatus');
//         });

//         $route->group(['prefix' => 'exports'], function ($route) {
//             $route->get('/', [WarehouseExportController::class, 'index'])->name('admin.warehouse.export.index');
//             $route->get('/create', [WarehouseExportController::class, 'create'])->name('admin.warehouse.export.create');
//             $route->post('/create', [WarehouseExportController::class, 'store'])->name('admin.warehouse.export.store');
//             $route->get('/update/{id}', [WarehouseExportController::class, 'edit'])->name('admin.warehouse.export.edit');
//             $route->post('/update/{id}', [WarehouseExportController::class, 'update'])->name('admin.warehouse.export.update');
//             $route->get('/update-status/{id}/{status}', [WarehouseExportController::class, 'updateStatus'])->name('admin.warehouse.export.updateStatus');
//         });

//         // $route->get('/update/{id}', [ProductionRequestController::class, 'edit'])->name('admin.production.update');
//         // $route->post('/update/{id}', [ProductionRequestController::class, 'update'])->name('admin.production.request.update');
//         // $route->get('/delete/{id}', [ProductionRequestController::class, 'destroy'])->name('admin.production.delete');
//         // $route->post('/update-completed', [ProductionRequestController::class, 'updateCompleted'])->name('admin.productionCompleted.request.update');
//         // $route->get('/export', [ProductionRequestController::class, 'export'])->name('admin.production.export');
//     });

//     $route->group(['prefix' => 'finances'], function ($route) {
//         $route->get('/', [FinanceController::class, 'index'])->name('admin.finance.index');
//         $route->get('/create', [FinanceController::class, 'create'])->name('admin.finance.create');
//         $route->post('/create', [FinanceController::class, 'store'])->name('admin.finance.request.create');
//         $route->get('/update/{id}', [FinanceController::class, 'edit'])->name('admin.finance.update');
//         $route->post('/update/{id}', [FinanceController::class, 'update'])->name('admin.finance.request.update');
//         $route->get('/delete/{id}', [FinanceController::class, 'delete'])->name('admin.finance.delete');
//         $route->get('/export', [FinanceController::class, 'export'])->name('admin.finance.export');
//         $route->get('/update-status/{id}/{status}', [FinanceController::class, 'updateStatus'])->name('admin.finance.updateStatus');
//     });

//     $route->group(['prefix' => 'plan-ingredient'], function ($route) {
//         $route->get('/create/{id_product}', [PlanIngredientController::class, 'create'])->name('admin.planIngredient.create');
//     });

//     $route->group(['prefix' => 'quota'], function ($route) {
//         $route->post('/create/{id_production}', [QuotaController::class, 'store'])->name('admin.quota.create.request');
//     });

//     $route->get('/assign/{id}', [TaskController::class, 'removeUser'])->name('admin.task.assign.remove');

//     $route->group(['prefix' => 'cost'], function ($route) {
//         $route->get('/', [CostController::class, 'getAll'])->name('admin.cost.index');
//         $route->get('/{idChatLuong}/{idDanhMuc}', [CostController::class, 'getCost'])->name('admin.cost.getBy');
//     });

//     $route->get('/invoice/{id}', [AdminController::class, 'getInvoice'])->name('admin.invoice');

//     $route->get('/image/delete/{type}/{idProvide}/{idImg}', [ImageController::class, 'delete'])->name('admin.image.delete');

//     $route->post('/image-update/{id}', [AdminController::class, 'updateImageUser'])->name('admin.user.image.update');
//     $route->post('/update/{id}', [AdminController::class, 'updateUser'])->name('admin.user.update');

//     $route->get('/requirement', [RequirementController::class, 'index'])->name('admin.requirement.index');
//     $route->get('/requirement/update-status/{id}', [RequirementController::class, 'updateStatus'])->name('admin.requirement.updateStatus');


//     $route->group(['prefix' => 'employee', 'middleware' => 'role:ADMIN,CEO,USER_HR,USER_MANAGER'], function ($route) {
//         $route->get('/', [UserController::class, 'index'])->name('admin.employee.index');
//         $route->post('/update/{id}', [UserController::class, 'updateStatus'])->name('admin.employee.updateStatus');
//     });
// });

//Resource
// Route::get('/revenue/get', [AdminController::class, 'getRevenue'])->name('revenue');
// Route::get('/debt/get', [AdminController::class, 'getDebt'])->name('debt');
// Route::get('/product-type/count', [AdminController::class, 'countTypeOrder'])->name('count.product-type');
