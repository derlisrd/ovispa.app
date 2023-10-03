<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovimientoController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login',[AuthController::class,'login'])->name('auth.login');
Route::post('/auth/register',[AuthController::class,'register'])->name('auth.register');

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/auth/check',[AuthController::class,'check'])->name('auth.check');
    Route::post('/auth/logout',[AuthController::class,'logout'])->name('auth.logout');
    Route::get('/auth/user',[AuthController::class,'user'])->name('auth.user');

    Route::get('/movimientos',[MovimientoController::class,'index'])->name('movimiento.index');
    Route::get('/movimientos/{id}',[MovimientoController::class,'show'])->name('movimiento.show');
    Route::post('/movimientos',[MovimientoController::class,'store'])->name('movimiento.store');
    Route::put('/movimientos/{id}',[MovimientoController::class,'update'])->name('movimiento.update');
    Route::delete('/movimientos/{id}',[MovimientoController::class,'destroy'])->name('movimiento.destroy');
});




