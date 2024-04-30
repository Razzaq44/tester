<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatDriverController;
use App\Http\Controllers\ConfirmOrderController;
use App\Http\Controllers\DriverController;


Route::get('/', [MenuController::class, 'index']);
Route::get('/orders', [OrderController::class, 'index']);
Route::post('/menus/{id}', [MenuController::class, 'store'])->name('menu.store');
Route::post('/tambah', [OrderController::class, 'tambahJumlah'])->name('order.tambah');
Route::post('/kurang', [OrderController::class, 'kurangJumlah'])->name('order.kurang');
Route::post('/hapus/{id}', [OrderController::class, 'destroy'])->name('order.hapus');
Route::get('/chat', [ChatController::class, 'index']);
Route::get('/chatDriver', [ChatDriverController::class, 'index']);
Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('send.message');
Route::post('/send-messageDriver', [ChatDriverController::class, 'sendMessage'])->name('send.messageD');
Route::get('/confirmOrder', [ConfirmOrderController::class, 'index']);
Route::post('/upload', [ConfirmOrderController::class, 'upload'])->name('upload');
Route::get('/driver', [DriverController::class, 'index'])->name('driver');
Route::post('/takeOrder/{id}', [DriverController::class, 'takeOrder']);
