<?php

use App\Http\Controllers\Apps\AuthController;
use App\Http\Controllers\Apps\DashboardController;
use App\Http\Controllers\Apps\InventoryController;
use App\Http\Controllers\Apps\PurchaseController;
use App\Http\Controllers\Apps\SalesController;
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

Route::get('/', function () {
    return view('');
});

Route::get('login', [AuthController::class, 'indexLogin'])->name('app.login.index');
Route::post('login', [AuthController::class, 'postLogin'])->name('app.login.post');
Route::get('register', [AuthController::class, 'indexRegister'])->name('app.register.index');
Route::post('register', [AuthController::class, 'postRegister'])->name('app.register.post');

Route::middleware('auth')->group(function () {
    Route::get('logout',[AuthController::class, 'logout'])->name('app.logout');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('app.dashboard.index');
    Route::resource('inventory', InventoryController::class)->names('app.inventory');
    Route::resource('purchase', PurchaseController::class)->names('app.purchase');
    Route::resource('sales', SalesController::class)->names('app.sales');
});
