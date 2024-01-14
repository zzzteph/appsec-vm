<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
 

Route::middleware(['auth'])->group(function () {
    Route::get('/rules',[MainController::class, 'rules'])->name('rules');
    Route::get('/leaderboard',[MainController::class, 'leaderboard'])->name('leaderboard');


    Route::get('/archived',[MainController::class, 'archived'])->name('archived');
    Route::get('/track/{track}',[MainController::class, 'track'])->name('track');
    Route::get('/',[MainController::class, 'dashboard'])->name('dashboard');
    Route::post('/',[MainController::class, 'submit'])->name('submit-flag');
});

Route::get('/login',[MainController::class, 'login'])->name('login');
Route::post('/auth/oauth/redirect', function (Request $request) {
    return Socialite::driver('google')->redirect();
})->name('oauth-login');
Route::get('/auth/oauth/callback',[MainController::class, 'social_login']);



Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
