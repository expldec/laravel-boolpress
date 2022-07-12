<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::middleware('auth')
    ->namespace('Admin')  // cartella dei Controller
    ->name('admin.')      // pima parte del nome della route
    ->prefix('admin')     // prefisso comune degli URL
    ->group(function() {  // il tutto si applica a un gruppo di rotte
        Route::get('/', 'HomeController@index')->name('home');
        Route::resource('posts', 'PostController');
    });

Route::get('{any?}', function() {
    return view('guest.home');
})->where('any', '.*');