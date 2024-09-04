<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlatcrudCrontroller;
use App\Http\Controllers\FlatguestController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GatepassController;
use App\Http\Controllers\OtpController;
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

// Route::middleware('auth')->group(function () {
    // Route::get('logout', [FlatcrudCrontroller::class, 'logout'])->name('logout');

Route::prefix('flatcrud')->name('flatcrud.')->group(function () {
    Route::get('/', [FlatcrudCrontroller::class, 'index'])->name('index');
    Route::get('create', [FlatcrudCrontroller::class, 'create'])->name('create');
    Route::post('store', [FlatcrudCrontroller::class, 'store'])->name('store');
    Route::get('edit/{id}', [FlatcrudCrontroller::class, 'edit'])->name('edit');
    Route::put('{id}/update', [FlatcrudCrontroller::class, 'update'])->name('update');
    Route::get('{id}/destroy', [FlatcrudCrontroller::class, 'destroy'])->name('destroy');
    Route::get('{id}/show', [FlatcrudCrontroller::class, 'show'])->name('show');
   
});
Route::prefix('flatguest')->name('flatguest.')->group(function () {
    Route::get('/', [FlatguestController::class, 'index'])->name('index');
    Route::get('create', [FlatguestController::class, 'create'])->name('create');
    Route::post('/generate-otp', [FlatguestController::class, 'generateOtp'])->name('generate.otp');
    Route::get('edit/{id}', [FlatguestController::class, 'edit'])->name('edit');
    Route::get('{id}/show', [FlatguestController::class, 'show'])->name('show');
    Route::get('{id}/destroy', [FlatguestController::class, 'destroy'])->name('destroy');
    Route::put('{id}/update', [FlatguestController::class, 'update'])->name('update');
    
    
});
Route::prefix('securtycheck')->name('securtycheck.')->group(function () {
    Route::get('otpview', [FlatguestController::class, 'otpview'])->name('otpview');
    Route::post('otpverify', [FlatguestController::class, 'otpverify'])->name('otpverify');

});