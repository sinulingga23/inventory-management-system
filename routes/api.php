<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestSupplierController;
use App\Http\Controllers\RestCategoryController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/server-side/suppliers', [RestSupplierController::class, 'serverSideProcessing']);
Route::get('/suppliers/{supplierId}', [RestSupplierController::class, 'getSupplierBySupplierId']);

Route::get('/categories/{categoryId}', [RestCategoryController::class, 'getCategoryByCategoryId']);
Route::post('/server-side/categories', [RestCategoryController::class, 'serverSideProcessing']);
Route::get('/suppliers/{categoryCode}/code-check', [RestCategoryController::class, 'isCategoryCodeExists']);
