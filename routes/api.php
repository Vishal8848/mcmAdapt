<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\McmProductsController;

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

Route::resource('/products', McmProductsController::class);

Route::get('/products/{month}/sales', [McmProductsController::class, 'sales']);

Route::get('/products/{range}/best', [McmProductsController::class, 'best']);

Route::get('/address/validate', [McmProductsController::class, 'validateAddress']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
