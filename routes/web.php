<?php

use App\Http\Controllers\FlatcrudCrontroller;
use Illuminate\Support\Facades\Route;

Route::prefix('flatcrud')->name('flatcrud.')->group(function () {
    Route::get('/', [FlatcrudCrontroller::class, 'index'])->name('index');
    Route::get('create', [FlatcrudCrontroller::class, 'create'])->name('create');
    Route::post('store', [FlatcrudCrontroller::class, 'store'])->name('store');
    Route::get('edit/{id}', [FlatcrudCrontroller::class, 'edit'])->name('edit');
    Route::put('{id}/update', [FlatcrudCrontroller::class, 'update'])->name('update');
    Route::get('{id}/destroy', [FlatcrudCrontroller::class, 'destroy'])->name('destroy');
    Route::get('{id}/show', [FlatcrudCrontroller::class, 'show'])->name('show');
   
});