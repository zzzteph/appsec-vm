<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
 
Route::middleware(['auth'])->group(function () {
	Route::get('/new_profile',[MainController::class, 'new_profile'])->name('new_profile');
	Route::get('/confirm',[MainController::class, 'confirm'])->name('confirm');
	Route::put('/confirm',[MainController::class, 'confirmed'])->name('confirmed');
	Route::delete('/logout',[MainController::class, 'logout'])->name('logout');
	
	
	
	
});

Route::middleware(['auth','confirmUser'])->group(function () {
	Route::get('/new_profile',[MainController::class, 'new_profile'])->name('new_profile');
	Route::get('/dashboard',[MainController::class, 'dashboard'])->name('dashboard');
	Route::get('/transfer',[MainController::class, 'transfer'])->name('transfer');
});


Route::get('api/stats',[MainController::class, 'api_get_stats'])->name('api_get_stats');	
Route::get('api/money',[MainController::class, 'api_get_money'])->name('api_get_money');	
Route::get('api/users',[MainController::class, 'api_get_users'])->name('api_get_users');
Route::get('api/users/{id}',[MainController::class, 'api_get_user_by_id'])->name('api_get_user_by_id');
Route::get('api/wallets',[MainController::class, 'api_get_wallets'])->name('api_get_wallets');
Route::get('api/wallets/{id}',[MainController::class, 'api_get_wallet'])->name('api_get_wallet');
Route::post('api/sign',[MainController::class, 'api_sign'])->name('api_sign');
Route::post('api/transfer',[MainController::class, 'api_transfer'])->name('api_transfer');	
Route::post('api/exchange/calculate',[MainController::class, 'api_exchange_calculate'])->name('api_exchange_calculate');
Route::post('api/exchange',[MainController::class, 'api_exchange'])->name('api_exchange');



Route::get('/',[MainController::class, 'main'])->name('main');
Route::post('/login',[MainController::class, 'auth'])->name('auth');
Route::get('/login',[MainController::class, 'login'])->name('login');
Route::get('/register',[MainController::class, 'register'])->name('register');
Route::post('/register',[MainController::class, 'create_account'])->name('create_account');



