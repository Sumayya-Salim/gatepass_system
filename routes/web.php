<?php

use App\Http\Controllers\AuthController;
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