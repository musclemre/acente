<?php

use App\Http\Controllers\Panel\AcenteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\KullaniciController;
use App\Http\Controllers\MusteriController;


Route::get('/', [HomeController::class, 'index']);


Auth::routes([
    'register' => false, // Kayıt olma (Register) sayfasını kapatır
    'reset' => false,    // Şifre sıfırlama (Forgot Password) sayfasını kapatır
    'verify' => false,   // E-posta doğrulama işlemini kapatır
]);

Route::group(['prefix' => 'panel', 'middleware' => ['auth', 'yetki'], 'as' => 'panel.'], function () {

    Route::get('/', [PanelController::class, 'index'])->name('dashboard');

    //Acenteler Start
    Route::resource('acenteler', AcenteController::class);
    Route::post('acente/check-slug', [AcenteController::class, 'checkSlug'])->name('acenteler.checkSlug');
    //Acenteler End

    //Kullanıcı İşlemleri Start
    Route::group(['prefix' => 'kullanicilar'], function () {
        Route::get('/', [KullaniciController::class, 'index'])->middleware('role:kullanici:y1');
        Route::get('ekle', [KullaniciController::class, 'ekle'])->middleware('role:kullanici:y2');
        Route::post('ekle', [KullaniciController::class, 'eklePost'])->middleware('role:kullanici:y2');
        Route::get('ajax-table', [KullaniciController::class, 'ajaxTableKullanicilar'])->middleware('role:kullanici:y1');
        Route::get('duzenle/{id}', [KullaniciController::class, 'duzenle'])->middleware('role:kullanici:y3');
        Route::post('duzenle/{id}', [KullaniciController::class, 'duzenlePost'])->middleware('role:kullanici:y3');
    });
    //Kullanıcı İşlemleri End

    //Müşteri İşlemleri Start
    Route::group(['prefix' => 'musteriler'], function () {
        Route::get('/', [MusteriController::class, 'index'])->middleware('role:musteri:y1');
        Route::get('ekle', [MusteriController::class, 'ekle'])->middleware('role:musteri:y2');
        Route::post('ekle', [MusteriController::class, 'eklePost'])->middleware('role:musteri:y2');
        Route::get('ajax-table', [MusteriController::class, 'ajaxTableMusteriler'])->middleware('role:musteri:y1');
        Route::get('duzenle/{id}', [MusteriController::class, 'duzenle'])->middleware('role:musteri:y3');
        Route::post('duzenle/{id}', [MusteriController::class, 'duzenlePost'])->middleware('role:musteri:y3');
    });
    //Müşteri İşlemleri End

});
