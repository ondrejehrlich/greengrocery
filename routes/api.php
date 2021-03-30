<?php

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

Route::resource('/product', ProductController::class)->only([
    'index', 'show', 'store', 'update', 'destroy',
]);
Route::resource('/boxes', BoxController::class)->only([
    'index', 'show', 'store', 'destroy',
]);

Route::get('/boxes/{box}/product/{product}', [BoxController::class, 'addProductToBox']);
