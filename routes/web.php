<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
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
    return view('welcome');
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
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function ($route) {
    $route->get('/', [AdminController::class, 'index'])->name('admin.home');
});
