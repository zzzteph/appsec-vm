<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/log-viewer');
});



Route::post('/api/log',function (Request $request) {
    
    if ($request->has(['message', 'severity'])) {
       Http::post('https://logio.justctf.online/api/log',[
    'message' => $request->input('message'),
    'severity' =>$request->input('severity'),
]);
}

});
