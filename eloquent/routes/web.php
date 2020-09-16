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

use App\Models\Post;
Route::get('eloquent', function () {
    // $posts = Post::all(); # Obtengo todos los posts
    $posts = Post::where('id', '>=', 20)
        ->orderBy('id', 'desc')
        ->take(5)
        ->get(); # Obtengo todos los posts

    foreach ($posts as $post){
        echo "$post->id $post->title <br>";
    }
});

Route::get('posts', function () {
    // $posts = Post::all(); # Obtengo todos los posts
    $posts = Post::get();

    foreach ($posts as $post){
        // Como lleva varios niveles, se encierran entre llaves
        echo "
        $post->id 
        <strong>{$post->user->get_name}</strong>
        $post->get_title <br>";
    }
});

use App\Models\User;
Route::get('users', function () {
    // $posts = Post::all(); # Obtengo todos los posts
    $users = User::all();

    foreach ($users as $user){
        echo "
            $user->id
            <strong>$user->name</strong>
            {$user->posts->count()} posts<br/>
        ";
    }
});

Route::get('collections', function () {
    // $posts = Post::all(); # Obtengo todos los posts
    $users = User::all();
    // dd($users);
    // dd($users->contains(4));
    // dd($users->except([1, 2, 4]));
    // dd($users->only(4));
    // dd($users->find(4));
    dd($users->load('posts'));
});

Route::get('serialization', function () {
    // $posts = Post::all(); # Obtengo todos los posts
    $users = User::all();

    // dd($users->toArray());
    $user = $users->find(1);
    // dd($user);
    // dd($user->toJson());
    print_r($user->toJson());
   
});