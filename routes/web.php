<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlatcrudCrontroller;
use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('index');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
Route::prefix('reset')->name('reset.')->group(function () {
    Route::get('/', [ForgotPasswordController::class, 'index'])->name('index');
    Route::post('/check',[ForgotPasswordController::class,'check'])->name('check');
    Route::get('/edit/{uuid}',[ForgotPasswordController::class,'edit'])->name('edit');
    Route::post('/updatepassword',[ForgotPasswordController::class,'updatepassword'])->name('updatepassword');

});


Route::prefix('flatcrud')->name('flatcrud.')->group(function () {
    Route::get('/', [FlatcrudCrontroller::class, 'index'])->name('index');
    Route::get('create', [FlatcrudCrontroller::class, 'create'])->name('create');
    Route::post('store', [FlatcrudCrontroller::class, 'store'])->name('store');
    Route::get('edit/{id}', [FlatcrudCrontroller::class, 'edit'])->name('edit');
    Route::put('{id}/update', [FlatcrudCrontroller::class, 'update'])->name('update');
    Route::get('{id}/destroy', [FlatcrudCrontroller::class, 'destroy'])->name('destroy');
    Route::get('{id}/show', [FlatcrudCrontroller::class, 'show'])->name('show');
   
});