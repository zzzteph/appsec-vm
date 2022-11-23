<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::get('admin_super_login_very_very_very_secret_123', [MainController::class, 'admin'])->name('admin');


Route::get('login', [MainController::class, 'login'])->name('login');
Route::post('login', [MainController::class, 'authentificate'])->name('authentificate');
Route::delete('logout', [MainController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
Route::get('secret_flag_2',[MainController::class, 'flag'])->name('secret_flag_2');
Route::get('main',[MainController::class, 'list'])->name('main');
Route::post('post',[MainController::class, 'post'])->name('post');
Route::get('view/{message_id}',[MainController::class, 'view'])->name('view');
Route::get('settings',[MainController::class, 'settings'])->name('settings');
Route::post('change',[MainController::class, 'change'])->name('change');
});