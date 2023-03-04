<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\QualityController;
use App\Http\Controllers\Api\AnalyticController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\FinanceController;
use App\Http\Controllers\Api\IngredientController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductionController;
use App\Http\Controllers\Api\ProductionRequestController;
use App\Http\Controllers\Api\ProviderController;
use App\Http\Controllers\Api\PurchaseRemindController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UploadImageController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WarehouseExportController;
use App\Http\Controllers\Api\WarehouseImportController;
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
    // $router->get('/', [AnalyticController::class, 'getRevenue']);
    // $router->get('/debt', [AnalyticController::class, 'getDebt']);
    // $router->get('/product-type', [AnalyticController::class, 'countTypeOrder']);
});

Route::group([
    'prefix' => 'customer',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [CustomerController::class, 'index']);
    // $router->get('/', [AnalyticController::class, 'getRevenue']);
    // $router->get('/debt', [AnalyticController::class, 'getDebt']);
    // $router->get('/product-type', [AnalyticController::class, 'countTypeOrder']);
});

Route::group([
    'prefix' => 'provider',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [ProviderController::class, 'index']);
    // $router->get('/', [AnalyticController::class, 'getRevenue']);
    // $router->get('/debt', [AnalyticController::class, 'getDebt']);
    // $router->get('/product-type', [AnalyticController::class, 'countTypeOrder']);
});

Route::group([
    'prefix' => 'task',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [TaskController::class, 'index']);
    // $router->get('/', [AnalyticController::class, 'getRevenue']);
    // $router->get('/debt', [AnalyticController::class, 'getDebt']);
    // $router->get('/product-type', [AnalyticController::class, 'countTypeOrder']);
});

Route::group([
    'prefix' => 'finance',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [FinanceController::class, 'index']);
    // $router->get('/', [AnalyticController::class, 'getRevenue']);
    // $router->get('/debt', [AnalyticController::class, 'getDebt']);
    // $router->get('/product-type', [AnalyticController::class, 'countTypeOrder']);
});

Route::group([
    'prefix' => 'ingredient',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [IngredientController::class, 'index']);
    // $router->get('/', [AnalyticController::class, 'getRevenue']);
    // $router->get('/debt', [AnalyticController::class, 'getDebt']);
    // $router->get('/product-type', [AnalyticController::class, 'countTypeOrder']);
});

Route::group([
    'prefix' => 'product',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [IngredientController::class, 'index']);
    // $router->get('/', [AnalyticController::class, 'getRevenue']);
    // $router->get('/debt', [AnalyticController::class, 'getDebt']);
    // $router->get('/product-type', [AnalyticController::class, 'countTypeOrder']);
});

Route::group([
    'prefix' => 'warehouse-import',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [WarehouseImportController::class, 'index']);
    // $router->get('/', [AnalyticController::class, 'getRevenue']);
    // $router->get('/debt', [AnalyticController::class, 'getDebt']);
    // $router->get('/product-type', [AnalyticController::class, 'countTypeOrder']);
});

Route::group([
    'prefix' => 'warehouse-export',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [WarehouseExportController::class, 'index']);
    // $router->get('/', [AnalyticController::class, 'getRevenue']);
    // $router->get('/debt', [AnalyticController::class, 'getDebt']);
    // $router->get('/product-type', [AnalyticController::class, 'countTypeOrder']);
});

Route::group([
    'prefix' => 'users',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [UserController::class, 'index']);
    // $router->get('/', [AnalyticController::class, 'getRevenue']);
    // $router->get('/debt', [AnalyticController::class, 'getDebt']);
    // $router->get('/product-type', [AnalyticController::class, 'countTypeOrder']);
});

Route::group([
    'prefix' => 'production-request',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [ProductionRequestController::class, 'index']);
    // $router->get('/', [AnalyticController::class, 'getRevenue']);
    // $router->get('/debt', [AnalyticController::class, 'getDebt']);
    // $router->get('/product-type', [AnalyticController::class, 'countTypeOrder']);
});

Route::group([
    'prefix' => 'production',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [ProductionController::class, 'index']);
    // $router->get('/', [AnalyticController::class, 'getRevenue']);
    // $router->get('/debt', [AnalyticController::class, 'getDebt']);
    // $router->get('/product-type', [AnalyticController::class, 'countTypeOrder']);
});

Route::group([
    'prefix' => 'purchase-remind',
    'middleware' => ['api']
], function ($router) {
    $router->get('/', [PurchaseRemindController::class, 'index']);
    // $router->get('/', [AnalyticController::class, 'getRevenue']);
    // $router->get('/debt', [AnalyticController::class, 'getDebt']);
    // $router->get('/product-type', [AnalyticController::class, 'countTypeOrder']);
});