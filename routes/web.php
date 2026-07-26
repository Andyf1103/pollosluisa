<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ShiftController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('shifts.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('employees', EmployeeController::class);
    Route::resource('shifts', ShiftController::class);
    Route::resource('inventories', InventoryController::class);
    Route::resource('sales', SaleController::class);
});

Route::middleware(['auth', 'role:admin,mesero'])->group(function () {
    Route::resource('customers', CustomerController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('order_details', OrderDetailController::class);
});

Route::middleware(['auth', 'role:admin,mesero,cocinero'])->group(function () {
    Route::post('orders/{order}/cambiar-estado', [OrderController::class, 'cambiarEstado'])->name('orders.cambiarEstado');
});

Route::middleware(['auth', 'role:cocinero'])->group(function () {
    Route::get('orders/pendientes', [OrderController::class, 'pendientes'])->name('orders.pendientes');
    Route::post('orders/{order}/preparar', [OrderController::class, 'preparar'])->name('orders.preparar');
    Route::post('orders/{order}/listo', [OrderController::class, 'listo'])->name('orders.listo');
});

Route::middleware(['auth', 'role:admin,mesero'])->group(function () {
    Route::post('orders/{order}/entregar', [OrderController::class, 'entregar'])->name('orders.entregar');
    Route::post('orders/{order}/cancelar', [OrderController::class, 'cancelar'])->name('orders.cancelar');
});

require __DIR__.'/auth.php';