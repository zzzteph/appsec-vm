<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;




Route::get('start',[MainController::class, 'start'])->name('start');
Route::get('/',[MainController::class, 'main'])->name('main');
Route::post('start',[MainController::class, 'new_game'])->name('new_game');

Route::get ('play/{id}',[MainController::class, 'play'])->name('play');
Route::get('game/{id}',[MainController::class, 'game'])->name('game');
Route::get('api/game/{id}',[MainController::class, 'api_get_game'])->name('api_get_game');
Route::post('api/game/{id}',[MainController::class, 'api_post_score'])->name('api_post_score');
Route::put('api/game/{id}',[MainController::class, 'api_update_score'])->name('api_update_score');

Route::get('leaderboard',[MainController::class, 'leaderboard'])->name('leaderboard');

