<?php

use App\Http\Controllers\admin\AmazonCategoryController;
use App\Http\Controllers\admin\AmazonSubCategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\CalculationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('auth/login');
//});

Route::get('/', [CalculationController::class, 'index']);


Route::get('/amazon-sub', [CalculationController::class, 'index']);
//Route::get('/calculation-result', [CalculationController::class, 'calculationResult'])->name('calculation.result');
Route::post('/calculation-result', [CalculationController::class, 'calculationResult'])->name('calculation.result');

Route::get('/amazon/{id}/sub-categories', [CalculationController::class, 'getAmazonSubCategories'])->name('amazon.sub.categories');

//Admin
Route::middleware('auth')->group(callback: function () {
    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Category Section
    Route::get('/amazon-category-section', [AmazonCategoryController::class, 'index'])->name('amazon.category.section');
    Route::post('/amazon-category-store', [AmazonCategoryController::class, 'store'])->name('amazon.category.store');
    Route::put('/amazon-category-update/{id}', [AmazonCategoryController::class, 'update'])->name('amazon.category.update');
    Route::get('/amazon-category-delete/{id}', [AmazonCategoryController::class, 'destroy'])->name('amazon.category.destroy');

    //Sub Category Section
    Route::get('/amazon-sub-category-section', [AmazonSubCategoryController::class, 'index'])->name('amazon.sub.category.section');
    Route::post('/amazon-sub-category-store', [AmazonSubCategoryController::class, 'store'])->name('amazon.sub.category.store');
    Route::put('/amazon-sub-category-update/{id}', [AmazonSubCategoryController::class, 'update'])->name('amazon.sub.category.update');
    Route::get('/amazon-sub-category-delete/{id}', [AmazonSubCategoryController::class, 'destroy'])->name('amazon.sub.category.destroy');
});
require __DIR__.'/auth.php';
