<?php

use App\Http\Controllers\AuthController;

use App\Http\Controllers\FlatcrudCrontroller;
use App\Http\Controllers\FlatguestController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\OwnercrudController;
use App\Http\Controllers\SecurityController;
use App\Http\Middleware\AuthenticateMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('index');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware(AuthenticateMiddleware::class)->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

   

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

    Route::prefix('securitycheck')->name('securitycheck.')->group(function () {
        Route::get('otpview', [FlatguestController::class, 'otpview'])->name('otpview');
        Route::post('otpverify', [FlatguestController::class, 'otpverify'])->name('otpverify');
    });

    Route::prefix('ownercrud')->name('owner_crud.')->group(function () {
        Route::get('/', [OwnercrudController::class, 'index'])->name('index');
        Route::get('create', [OwnercrudController::class, 'create'])->name('create');
        Route::post('store', [OwnercrudController::class, 'store'])->name('store');
        Route::get('edit/{id}', [OwnercrudController::class, 'edit'])->name('edit');
        Route::put('{id}/update', [OwnercrudController::class, 'update'])->name('update');
        Route::get('{id}/destroy', [OwnercrudController::class, 'destroy'])->name('destroy');
        Route::get('{id}/show', [OwnercrudController::class, 'show'])->name('show');
    });
    Route::prefix('security')->name('security.')->group(function () {
        Route::get('/', [SecurityController::class, 'index'])->name('index');
        Route::get('create', [SecurityController::class, 'create'])->name('create');
        Route::post('store', [SecurityController::class, 'store'])->name('store');
        Route::get('edit/{id}', [SecurityController::class, 'edit'])->name('edit');
        Route::put('{id}/update', [SecurityController::class, 'update'])->name('update');
        Route::get('{id}/destroy', [SecurityController::class, 'destroy'])->name('destroy');
       
    });
});

 Route::prefix('reset')->name('reset.')->group(function () {
        Route::get('/', [ForgotPasswordController::class, 'index'])->name('index');
        Route::post('/check', [ForgotPasswordController::class, 'check'])->name('check');
        Route::get('/edit/{uuid}', [ForgotPasswordController::class, 'edit'])->name('edit');
        Route::post('/updatepassword', [ForgotPasswordController::class, 'updatepassword'])->name('updatepassword');
    });
Route::fallback(function () {
    abort(404);
});
