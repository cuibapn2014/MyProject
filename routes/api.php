<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\QualityController;
use App\Http\Controllers\Api\AnalyticController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\FinanceController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\IngredientController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductionController;
use App\Http\Controllers\Api\ProductionRequestController;
use App\Http\Controllers\Api\ProviderController;
use App\Http\Controllers\Api\Select\ProviderSelectController;
use App\Http\Controllers\Api\PurchaseRemindController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UploadImageController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WarehouseExportController;
use App\Http\Controllers\Api\WarehouseImportController;
use App\Http\Controllers\Api\Select\IngredientTypeSelectController;
use App\Http\Controllers\Api\Select\ProductSelectController;
use App\Http\Controllers\Api\QuotaController;
use App\Http\Controllers\Api\Select\CustomerSelectController;
use App\Http\Controllers\Api\Select\StageSelectController;
use App\Http\Controllers\Api\Select\UnitCalSelectController;
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

// Route::get('/quality', [QualityController::class, 'index'])->middleware('api');
// Route::get('/category', [CategoryController::class, 'index'])->middleware('api');
// Route::get('/ingredient', [IngredientController::class, 'getAll'])->middleware('api');
// Route::post('/quota/create/{id_product}', [QuotaController::class, 'store']);

Route::group([
    'middleware' => ['api'],
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('/change-pass', [AuthController::class, 'changePassWord']);
    Route::post('/change-avatar', [UploadImageController::class, 'update']);
    Route::put('/update', [AuthController::class, 'update']);
});

//Forgot password
Route::post('/auth/forgot-password', [ForgotPasswordController::class, 'postForgotPassword']);

Route::group([
    'middleware' => ['api']
], function ($router) {
    $router->get('/analytic', [AnalyticController::class, 'index']);
    $router->get('/revenue', [AnalyticController::class, 'getRevenue']);
    $router->get('/debt', [AnalyticController::class, 'getDebt']);
    $router->get('/product-type', [AnalyticController::class, 'countTypeOrder']);
});

Route::group([
    'prefix' => 'order',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [OrderController::class, 'index']);
    $router->get('/{id}', [OrderController::class, 'show']);
    $router->post('/update-status/{id}', [OrderController::class, 'updateStatus']);
    $router->post('/create', [OrderController::class, 'store']);
    $router->post('/update/{id}', [OrderController::class, 'update']);
    $router->delete('/delete/{id}', [OrderController::class, 'destroy']);
});

Route::group([
    'prefix' => 'customer',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [CustomerController::class, 'index']);
    $router->get('/{id}', [CustomerController::class, 'show']);
    $router->post('/create', [CustomerController::class, 'store']);
    $router->put('/update/{id}', [CustomerController::class, 'update']);
    $router->delete('/delete/{id}', [CustomerController::class, 'destroy']);
});

Route::group([
    'prefix' => 'provider',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [ProviderController::class, 'index']);
    $router->get('/{id}', [ProviderController::class, 'show']);
    $router->post('/create', [ProviderController::class, 'store']);
    $router->put('/update/{id}', [ProviderController::class, 'update']);
    $router->delete('/delete/{id}', [ProviderController::class, 'destroy']);
});

Route::group([
    'prefix' => 'task',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [TaskController::class, 'index']);
});

Route::group([
    'prefix' => 'finance',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [FinanceController::class, 'index']);
});

Route::group([
    'prefix' => 'ingredient',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [IngredientController::class, 'index']);
    $router->get('/{id}', [IngredientController::class, 'show']);
    $router->post('/create', [IngredientController::class, 'store']);
    $router->post('/update/{id}', [IngredientController::class, 'update']);
    $router->delete('/delete/{id}', [IngredientController::class, 'destroy']);
});

Route::group([
    'prefix' => 'product',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [IngredientController::class, 'index']);
});

Route::group([
    'prefix' => 'quota',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [QuotaController::class, 'index']);
    $router->post('/create', [QuotaController::class, 'store']);
});

Route::group([
    'prefix' => 'warehouse-import',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [WarehouseImportController::class, 'index']);
});

Route::group([
    'prefix' => 'warehouse-export',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [WarehouseExportController::class, 'index']);
});

Route::group([
    'prefix' => 'users',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [UserController::class, 'index']);
    $router->delete('/delete/{id}', [UserController::class, 'destroy']);
});

Route::group([
    'prefix' => 'production-request',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [ProductionRequestController::class, 'index']);
});

Route::group([
    'prefix' => 'production',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [ProductionController::class, 'index']);
});

Route::group([
    'prefix' => 'purchase-remind',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [PurchaseRemindController::class, 'index']);
});

// Select box
Route::group([
    'prefix' => 'select-box',
    'middleware' => ['api']
], function ($router) {
    $router->get('ingredient-type', [IngredientTypeSelectController::class, 'index']);
    $router->get('unit-cal', [UnitCalSelectController::class, 'index']);
    $router->get('stage', [StageSelectController::class, 'index']);
    $router->get('product', [ProductSelectController::class, 'index']);
    $router->get('ingredient', [IngredientController::class, 'getDataBySelectBox']);
    $router->get('customer', [CustomerSelectController::class, 'index']);
    $router->get('provider', [ProviderSelectController::class, 'index']);
});


// File
Route::delete('image/delete/{id}', [ImageController::class, 'destroy'])->middleware('api');