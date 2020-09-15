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

use App\Http\Controllers\UserController;
Route::get(
  '/', [UserController::class, 'index']
)->middleware('guest'); // Listar usuarios

Route::post('users', [UserController::class, 'store'])->name('users.store');

Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

use App\Http\Controllers\PageController;
Route::resource('pages', PageController::class); # Se crean 7 rutas por defecto

use App\Http\Controllers\PostController;
Route::get('post', function(){
  return view('post.posts');
});

Route::post('post', [PostController::class, 'store'])->name('posts.store');

// Vista Home trabajando con Blade
Route::view('/home', 'home');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
