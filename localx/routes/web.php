<?php

use App\Http\Controllers\Panel\AcenteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\KullaniciController;


Route::get('/', [HomeController::class, 'index']);


Auth::routes([
    'register' => false, // Kayıt olma (Register) sayfasını kapatır
    'reset' => false,    // Şifre sıfırlama (Forgot Password) sayfasını kapatır
    'verify' => false,   // E-posta doğrulama işlemini kapatır
]);


Route::group(['prefix' => 'panel', 'middleware' => 'auth', 'as' => 'panel.'], function () {

    Route::get('/', [PanelController::class, 'index'])->name('dashboard');

    Route::resource('acenteler', AcenteController::class);
});


Route::group(['prefix' => 'panel','middleware' => ['auth','yetki']], function() {
	
	//Kullanıcı İşlemleri Start
	Route::group(['prefix' => 'kullanicilar'], function ()
	{	
		Route::get('/',						[KullaniciController::class,'index'])->middleware('role:kullanici:y1');
		Route::get('ekle',					[KullaniciController::class,'ekle'])->middleware('role:kullanici:y2');
		Route::post('ekle',					[KullaniciController::class,'eklePost'])->middleware('role:kullanici:y2');
		Route::get('ajax-table',			[KullaniciController::class,'ajaxTableKullanicilar'])->middleware('role:kullanici:y1');
		Route::get('duzenle/{id}',			[KullaniciController::class,'duzenle'])->middleware('role:kullanici:y3');
		Route::post('duzenle/{id}',			[KullaniciController::class,'duzenlePost'])->middleware('role:kullanici:y3');
	});
	//Kullanıcı İşlemleri End
});
