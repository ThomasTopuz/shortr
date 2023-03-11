<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

Route::get('/', [\App\Http\Controllers\UrlController::class, 'index'])->middleware('auth');

Route::post('/shorten', [\App\Http\Controllers\UrlController::class, 'shorten'])->name('shorten')->middleware('auth');


Route::get('/auth/google/callback', [\App\Http\Controllers\SocialController::class, 'handleCallback'])->name('google.login.callback');


Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
})->name('google.login');

Route::get('/{short}', [\App\Http\Controllers\UrlController::class, 'resolve']);
