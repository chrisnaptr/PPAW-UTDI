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

Route::get('segi-empat/inputBalok', [\App\Http\Controllers\SegiEmpatController::class, 'inputBalok'])->name('segi-empat.inputSegiEmpat'); 

Route::get('segi-empat/hasilBalok', [\App\Http\Controllers\SegiEmpatController::class, 'hasilBalok'])->name('segi-empat.hasilBalok'); 

Route::get('segitiga-siku/input', [\App\Http\Controllers\SegitigaSikuController::class,'input'])->name('segitiga-siku.input');

Route::get('segitiga-siku/hasil',[\App\Http\Controllers\SegitigaSikuController::class, 'hasil'])->name('segitiga-siku.hasil');

Route::get('segitiga-siku/inputLimas', [\App\Http\Controllers\SegitigaSikuController::class,'inputLimas'])->name('segitiga-siku.inputLimas');

Route::get('segitiga-siku/hasilLimas',[\App\Http\Controllers\SegitigaSikuController::class,'hasilLimas'])->name('segitiga-siku.hasilLimas');

Route::get('akreditasi/index', [\App\Http\Controllers\AkreditasiController::class,'index'])->name('akreditasi.index');

Route::get('akreditasi/create', [\App\Http\Controllers\AkreditasiController::class,'create'])->name('akreditasi.create');

Route::get('akreditasi/', [\App\Http\Controllers\AkreditasiController::class,'create'])->name('akreditasi.create');

Route::resource('/akreditasi', \App\Http\Controllers\AkreditasiController::class);
