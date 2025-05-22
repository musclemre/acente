<?php

use App\Http\Controllers\Panel\AcenteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PanelController;


Route::get('/', [HomeController::class, 'index']);


Auth::routes([
    'register' => false, // Kayıt olma (Register) sayfasını kapatır
    'reset' => false,    // Şifre sıfırlama (Forgot Password) sayfasını kapatır
    'verify' => false,   // E-posta doğrulama işlemini kapatır
]);


Route::group(['prefix' => 'panel', 'middleware' => 'auth', 'as' => 'panel.'], function () {

    Route::get('/', [PanelController::class, 'index'])->name('dashboard');

    Route::resource('acenteler', AcenteController::class);
    Route::post('acente/check-slug', [AcenteController::class, 'checkSlug'])->name('acenteler.checkSlug');
});
