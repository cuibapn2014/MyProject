<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\Admin\QualityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/quality', [QualityController::class, 'index'])->middleware('api');
Route::get('/category', [CategoryController::class, 'index'])->middleware('api');
Route::get('/ingredient', [IngredientController::class, 'getAll'])->middleware('api');
// Route::post('/quota/create/{id_product}', [QuotaController::class, 'store']);
