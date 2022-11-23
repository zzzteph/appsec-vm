<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
 


Route::get('/insert',[MainController::class, 'insert_flag']);

Route::get('/',[MainController::class, 'dashboard']);
Route::post('/',[MainController::class, 'submit'])->name('submit-flag');



Route::post('/auth/oauth/redirect', function (Request $request) {
    return Socialite::driver('google')->redirect();
})->name('oauth-login');
Route::get('/auth/oauth/callback',[MainController::class, 'social_login']);



Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
