<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('segi-empat/input', [\App\Http\Controllers\SegiEmpatController::class,'inputSegiEmpat'])->name('segi-empat.inputSegiEmpat');

Route::get('segi-empat/hasil', [\App\Http\Controllers\SegiEmpatController::class,'hasil'])->name('segi-empat.hasil');
