<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CategoryController;
use App\Models\Supplier;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
Route::put('/suppliers/{supplierId}', [SupplierController::class, 'update'])->name('suppliers.update');
Route::delete('/suppliers/{supplierId}/delete', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::put('/categories/{categoryId}', [CategoryController::class, 'update'])->name('categoris.update');
Route::delete('/categories/{categoryId}/delete', [CategoryController::class, 'destroy'])->name('categoris.destroy');
