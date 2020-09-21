<?php

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

/* Route::get('/', function () {
    return view('welcome');
}); */

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use App\Http\Controllers\PageController;
Route::get('/', [PageController::class, 'posts']);
Route::get('/blog/{post:slug}', [PageController::class, 'post'])->name('post');


use App\Http\Controllers\Backend\PostController;
Route::resource('posts', PostController::class)
    ->middleware('auth')
    ->except('show');