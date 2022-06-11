<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CostController;
use App\Http\Controllers\Admin\FabricController;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\TaskController;
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
    // return view('welcome');
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

//Admin Route
Route::group(['prefix' => 'admin', 'middleware' => 'user'], function ($route) {
    $route->get('/', [AdminController::class, 'index'])->name('admin.home');

    $route->group(['prefix' => 'fabric'], function ($route) {
        $route->get('/', [FabricController::class, 'index'])->name('admin.fabric.index');
        $route->get('/create', [FabricController::class, 'getStore'])->name('admin.fabric.create');
        $route->post('/create', [FabricController::class, 'store'])->name('admin.fabric.request.create');
        $route->get('/update/{id}', [FabricController::class, 'getUpdate'])->name('admin.fabric.update');
        $route->post('/update/{id}', [FabricController::class, 'update'])->name('admin.fabric.request.update');
        $route->get('/delete/{id}', [FabricController::class, 'delete'])->name('admin.fabric.delete');
    });

    $route->group(['prefix' => 'ingredient'], function ($route) {
        $route->get('/', [IngredientController::class, 'index'])->name('admin.ingredient.index');
        $route->get('/create', [IngredientController::class, 'getStore'])->name('admin.ingredient.create');
        $route->post('/create', [IngredientController::class, 'store'])->name('admin.ingredient.request.create');
        $route->get('/update/{id}', [IngredientController::class, 'getUpdate'])->name('admin.ingredient.update');
        $route->post('/update/{id}', [IngredientController::class, 'update'])->name('admin.ingredient.request.update');
        $route->get('/delete/{id}', [IngredientController::class, 'delete'])->name('admin.ingredient.delete');
    });

    $route->group(['prefix' => 'order'], function ($route) {
        $route->get('/', [OrderController::class, 'index'])->name('admin.order.index');
        $route->get('/create', [OrderController::class, 'create'])->name('admin.order.create');
        $route->post('/create', [OrderController::class, 'store'])->name('admin.order.request.create');
        $route->get('/update/{id}', [OrderController::class, 'edit'])->name('admin.order.update');
        $route->post('/update/{id}', [OrderController::class, 'update'])->name('admin.order.request.update');
        $route->get('/delete/{id}', [OrderController::class, 'delete'])->name('admin.order.delete');
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

    $route->get('/assign/{id}', [TaskController::class, 'removeUser'])->name('admin.task.assign.remove');

    $route->group(['prefix' => 'cost'], function ($route) {
        $route->get('/', [CostController::class, 'getAll'])->name('admin.cost.index');
        $route->get('/{idChatLuong}/{idDanhMuc}', [CostController::class, 'getCost'])->name('admin.cost.getBy');
    });
    
    $route->get('/invoice/{id}', [AdminController::class, 'getInvoice'])->name('admin.invoice');

    $route->get('/image/delete/{type}/{idProvide}/{idImg}', [ImageController::class, 'delete'])->name('admin.image.delete');

    $route->post('/image-update/{id}', [AdminController::class, 'updateImageUser'])->name('admin.user.image.update');
    $route->post('/update/{id}', [AdminController::class, 'updateUser'])->name('admin.user.update');

});
