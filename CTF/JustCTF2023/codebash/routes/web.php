<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
 
Route::middleware(['auth','confirmUser'])->group(function () {
	
	Route::get('/',[MainController::class, 'challenges'])->name('challenges');
	
	Route::get('/leaderboard',[MainController::class, 'leaderboard']);
	Route::get('/challenges/{id}',[MainController::class, 'view'])->name('view');
	Route::post('/challenges/{id}/answer',[MainController::class, 'answer'])->name('answer');
	Route::get('/admin/challenges',[AdminController::class, 'list_challenges'])->name('list_challenges');
	Route::get('/admin/challenges/new',[AdminController::class, 'new_challenge'])->name('new_challenge');
	Route::post('/admin/challenges/new',[AdminController::class, 'insert_challenge'])->name('insert_challenge');
	Route::get('/admin/challenges/{id}/edit',[AdminController::class, 'edit_challenge'])->name('edit_challenge');
	Route::put('/admin/challenges/{id}/edit',[AdminController::class, 'update_challenge'])->name('update_challenge');
	Route::get('/admin/challenges/{id}',[AdminController::class, 'view_challenge'])->name('view_challenge');
	Route::get('/admin/answers',[AdminController::class, 'answers'])->name('answers');
	Route::get('/admin/answers/{id}',[AdminController::class, 'view_answer'])->name('view_answer');
	Route::delete('/admin/answers/{id}',[AdminController::class, 'delete_answer'])->name('delete_answer');
	Route::put('/admin/answers/{id}/correct',[AdminController::class, 'correct_answer'])->name('correct_answer');
	Route::put('/admin/answers/{id}/wrong',[AdminController::class, 'wrong_answer'])->name('wrong_answer');
	Route::get('/profile',[MainController::class, 'profile'])->name('profile');
	Route::put('/profile',[MainController::class, 'update_profile'])->name('profile');
	Route::get('/api/answers',[ApiController::class, 'answers'])->name('api_answers');
	Route::delete('/logout',[MainController::class, 'logout'])->name('logout');
	
});
Route::middleware(['auth'])->group(function () {
	Route::get('/intro', function () {    return view('intro');})->name('intro');
	Route::post('/intro_done',[MainController::class, 'intro_done'])->name('intro_done');
});

Route::get('/api/challenges',[ApiController::class, 'challenges'])->name('api_challenges');
Route::get('/api/countdown',[ApiController::class, 'countdown'])->name('api_countdown');
Route::get('/rules',[MainController::class, 'rules'])->name('rules');



Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/leaderboard',[MainController::class, 'leaderboard'])->name('leaderboard');


Route::post('/auth/oauth/redirect', function (Request $request) {
    return Socialite::driver('google')->redirect();
})->name('oauth-login');
Route::get('/auth/oauth/callback',[MainController::class, 'social_login']);



