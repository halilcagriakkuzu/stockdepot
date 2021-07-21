<?php

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
/** PANEL */
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/products/{id}/change-status/{status}', [App\Http\Controllers\ProductStatusController::class, 'changeProductStatus'])->name('productStatus.changeProductStatus');
Route::post('/products/{id}/change-status-maintenance', [App\Http\Controllers\ProductStatusController::class, 'sendToMaintenance'])->name('productStatus.sendToMaintenance');
Route::post('/products/{id}/change-status-disabled', [App\Http\Controllers\ProductStatusController::class, 'markAsDisabled'])->name('productStatus.markAsDisabled');
Route::post('/products/{id}/change-status-depot', [App\Http\Controllers\ProductStatusController::class, 'sendToDepot'])->name('productStatus.sendToDepot');
Route::get('/depots/maintenance', [App\Http\Controllers\DepotController::class, 'showMaintenance'])->name('depots.showMaintenance');
Route::get('/rentForms/{id}/addProduct/{productId}', [App\Http\Controllers\RentFormController::class, 'addForm'])->name('rentForms.addForm');
Route::post('/rentForms/{id}/addProduct/{productId}', [App\Http\Controllers\RentFormController::class, 'addFormStore'])->name('rentForms.addFormStore');
Route::get('/rentForms/{id}/removeProduct/{productId}', [App\Http\Controllers\RentFormController::class, 'removeProductFromRentForm'])->name('rentForms.removeProductFromRentForm');
Route::get('/rentForms/{id}/activate', [App\Http\Controllers\RentFormController::class, 'activateRentForm'])->name('rentForms.activateRentForm');
Route::get('/rentForms/{id}/removeProductFromActive/{productId}', [App\Http\Controllers\RentFormController::class, 'removeProductFromActiveRentForm'])->name('rentForms.removeProductFromActiveRentForm');

Route::resource('users', \App\Http\Controllers\UserController::class);
Route::resource('depots', \App\Http\Controllers\DepotController::class);
Route::resource('companies', \App\Http\Controllers\CompanyController::class);
Route::resource('categories', \App\Http\Controllers\CategoryController::class);
Route::resource('products', \App\Http\Controllers\ProductController::class);
Route::resource('rentForms', \App\Http\Controllers\RentFormController::class);

/** AUTH */
Auth::routes();
Route::any('/register', function() {return  view('auth.login');});

