<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BoxController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\SupplierController;

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

Route::resource('/products', ProductController::class)->only([
    'index', 'show', 'store', 'update', 'destroy',
]);

Route::resource('/boxes', BoxController::class)->only([
    'index', 'show', 'store', 'destroy',
]);

Route::get('/suppliers', [SupplierController::class, 'index']);

Route::post('/add-to-box/box/{box}/product/{product}', [BoxController::class, 'addProductToBox']);
