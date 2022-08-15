<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CostController;
use App\Http\Controllers\Admin\FabricController;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductionRequestController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\ProviderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\RequirementController;
use App\Http\Controllers\Admin\UserController;
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

Auth::routes();

Route::get('/', function () {
    return view('home');
    return redirect()->route('admin.home');
})->name('home');

// Register
Route::get('/register', [AuthController::class, 'getRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('request.register');


// Login
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('request.login');

// Logout
Route::get('/logout', function () {
    if (Auth::check()) Auth::logout();
    else return redirect()->route('login');
    return redirect()->route('home');
})->middleware('auth')->name('logout');

//Forgot password
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot');
Route::post('/forgot-password', [AuthController::class, 'postForgotPassword'])->name('auth.forgot.request');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('auth.password.update');

//Admin Route
Route::group(['prefix' => 'admin', 'middleware' => 'user'], function ($route) {
    $route->get('/', [AdminController::class, 'index'])->name('admin.home');

    $route->group(['prefix' => 'customer'], function ($route) {
        $route->get('/', [CustomerController::class, 'index'])->name('admin.customer.index');
        // $route->get('/all', [CustomerController::class, 'findByAll'])->name('admin.customer.getAll');
        $route->get('/create', [CustomerController::class, 'create'])->name('admin.customer.create');
        $route->post('/create', [CustomerController::class, 'store'])->name('admin.customer.request.create');
        $route->get('/update/{id}', [CustomerController::class, 'edit'])->name('admin.customer.update');
        $route->post('/update/{id}', [CustomerController::class, 'update'])->name('admin.customer.request.update');
        $route->get('/delete/{id}', [CustomerController::class, 'destroy'])->name('admin.customer.delete');
        // $route->get('/export', [CustomerController::class, 'export'])->name('admin.fabric.export');
    });

    $route->group(['prefix' => 'provider'], function ($route) {
        $route->get('/', [ProviderController::class, 'index'])->name('admin.provider.index');
        $route->get('/all', [ProviderController::class, 'findByAll'])->name('admin.provider.getAll');
        $route->get('/create', [ProviderController::class, 'create'])->name('admin.provider.create');
        $route->post('/create', [ProviderController::class, 'store'])->name('admin.provider.request.create');
        $route->get('/update/{id}', [ProviderController::class, 'edit'])->name('admin.provider.update');
        $route->post('/update/{id}', [ProviderController::class, 'update'])->name('admin.provider.request.update');
        $route->get('/delete/{id}', [ProviderController::class, 'destroy'])->name('admin.provider.delete');
        // $route->get('/export', [ProviderController::class, 'export'])->name('admin.fabric.export');
    });

    $route->group(['prefix' => 'fabric'], function ($route) {
        $route->get('/', [FabricController::class, 'index'])->name('admin.fabric.index');
        $route->get('/create', [FabricController::class, 'getStore'])->name('admin.fabric.create');
        $route->post('/create', [FabricController::class, 'store'])->name('admin.fabric.request.create');
        $route->get('/update/{id}', [FabricController::class, 'getUpdate'])->name('admin.fabric.update');
        $route->post('/update/{id}', [FabricController::class, 'update'])->name('admin.fabric.request.update');
        $route->get('/delete/{id}', [FabricController::class, 'delete'])->name('admin.fabric.delete');
        $route->get('/export', [FabricController::class, 'export'])->name('admin.fabric.export');
    });

    $route->group(['prefix' => 'ingredient'], function ($route) {
        $route->get('/', [IngredientController::class, 'index'])->name('admin.ingredient.index');
        $route->get('/create', [IngredientController::class, 'getStore'])->name('admin.ingredient.create');
        $route->post('/create', [IngredientController::class, 'store'])->name('admin.ingredient.request.create');
        $route->get('/update/{id}', [IngredientController::class, 'getUpdate'])->name('admin.ingredient.update');
        $route->post('/update/{id}', [IngredientController::class, 'update'])->name('admin.ingredient.request.update');
        $route->get('/delete/{id}', [IngredientController::class, 'delete'])->name('admin.ingredient.delete');
        $route->get('/export', [IngredientController::class, 'export'])->name('admin.ingredient.export');
    });

    $route->group(['prefix' => 'product'], function ($route) {
        $route->get('/', [ProductController::class, 'index'])->name('admin.product.index');
        $route->get('/create', [ProductController::class, 'create'])->name('admin.product.create');
        $route->post('/create', [ProductController::class, 'store'])->name('admin.product.request.create');
        $route->get('/update/{id}', [ProductController::class, 'edit'])->name('admin.product.update');
        $route->post('/update/{id}', [ProductController::class, 'update'])->name('admin.product.request.update');
        $route->get('/delete/{id}', [ProductController::class, 'delete'])->name('admin.product.delete');
        // $route->get('/export', [ProductController::class, 'export'])->name('admin.product.export');
    });


    $route->group(['prefix' => 'order'], function ($route) {
        $route->get('/', [OrderController::class, 'index'])->name('admin.order.index');
        $route->get('/create', [OrderController::class, 'create'])->name('admin.order.create');
        $route->post('/create', [OrderController::class, 'store'])->name('admin.order.request.create');
        $route->get('/update/{id}', [OrderController::class, 'edit'])->name('admin.order.update');
        $route->post('/update/{id}', [OrderController::class, 'update'])->name('admin.order.request.update');
        $route->get('/delete/{id}', [OrderController::class, 'delete'])->name('admin.order.delete');
        $route->get('/export', [OrderController::class, 'export'])->name('admin.order.export');
    });

    $route->group(['prefix' => 'task'], function ($route) {
        $route->get('/', [TaskController::class, 'index'])->name('admin.task.index');
        $route->get('/user', [TaskController::class, 'getListTask'])->name('admin.task.user.index');
        $route->get('/get', [TaskController::class, 'getByUser'])->name('admin.task.user.get');
        $route->get('/create', [TaskController::class, 'create'])->name('admin.task.create');
        $route->post('/create', [TaskController::class, 'store'])->name('admin.task.request.create');
        $route->get('/update/{id}', [TaskController::class, 'edit'])->name('admin.task.update');
        $route->post('/update/{id}', [TaskController::class, 'update'])->name('admin.task.request.update');
        $route->get('/delete/{id}', [TaskController::class, 'delete'])->name('admin.task.delete');
    });

    $route->group(['prefix' => 'production'], function ($route) {
        $route->get('/', [ProductionRequestController::class, 'index'])->name('admin.production.index');
        $route->get('/create', [ProductionRequestController::class, 'create'])->name('admin.production.create');
        $route->post('/create', [ProductionRequestController::class, 'store'])->name('admin.production.request.create');
        $route->get('/update/{id}', [ProductionRequestController::class, 'edit'])->name('admin.production.update');
        $route->post('/update/{id}', [ProductionRequestController::class, 'update'])->name('admin.production.request.update');
        $route->get('/delete/{id}', [ProductionRequestController::class, 'destroy'])->name('admin.production.delete');
        $route->get('/export', [ProductionRequestController::class, 'export'])->name('admin.production.export');
    });

    $route->group(['prefix' => 'plan'], function ($route) {
        $route->get('/', [PlanController::class, 'index'])->name('admin.plan.index');
        $route->get('/{id}/create', [PlanController::class, 'create'])->name('admin.plan.create');
        $route->post('/create', [PlanController::class, 'store'])->name('admin.plan.request.create');
        $route->get('/update/{id}', [PlanController::class, 'edit'])->name('admin.plan.update');
        $route->post('/update/{id}', [PlanController::class, 'update'])->name('admin.plan.request.update');
        $route->get('/delete/{id}', [PlanController::class, 'destroy'])->name('admin.plan.delete');
        $route->get('/create-buy/{id}', [PlanController::class, 'createBuy'])->name('admin.buy.create');
        $route->get('/export', [PlanController::class, 'export'])->name('admin.plan.export');
    });

    $route->get('/assign/{id}', [TaskController::class, 'removeUser'])->name('admin.task.assign.remove');

    $route->group(['prefix' => 'cost'], function ($route) {
        $route->get('/', [CostController::class, 'getAll'])->name('admin.cost.index');
        $route->get('/{idChatLuong}/{idDanhMuc}', [CostController::class, 'getCost'])->name('admin.cost.getBy');
    });

    $route->get('/invoice/{id}', [AdminController::class, 'getInvoice'])->name('admin.invoice');

    $route->get('/image/delete/{type}/{idProvide}/{idImg}', [ImageController::class, 'delete'])->name('admin.image.delete');

    $route->post('/image-update/{id}', [AdminController::class, 'updateImageUser'])->name('admin.user.image.update');
    $route->post('/update/{id}', [AdminController::class, 'updateUser'])->name('admin.user.update');

    $route->get('/requirement', [RequirementController::class, 'index'])->name('admin.requirement.index');

    $route->group(['prefix' => 'employee'], function ($route) {
        $route->get('/', [UserController::class, 'index'])->name('admin.employee.index');
    });
});

//Resource
Route::get('/revenue/get',[AdminController::class ,'getRevenue'])->name('revenue');
Route::get('/debt/get',[AdminController::class ,'getDebt'])->name('debt');
Route::get('/product-type/count',[AdminController::class ,'countTypeOrder'])->name('count.product-type');
