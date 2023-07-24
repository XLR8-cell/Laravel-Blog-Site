<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use Illuminate\Support\Facades\File;


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

Route::get(
    '/',
    function () {
        $posts = Post::all();

        return view('posts', ['posts' => $posts]);
    }
);

Route::get(
    'posts/{post}', # wildcard post is passed as the parameter $slug
    function ($slug) {
        #The __DIR__ directory of the current PHP file.C:\Users\Bucky\Desktop\blog\routes
        #$path = (__DIR__ . "/../resources/posts/{$slug}.html");
        #/../ is used to traverse one level up from the current directory. It represents the parent directory.

        #find a post using its slug and pass it to a view called "post"

        return view('post', ['post' => Post::find($slug)]);
    }
)->where('post', '[a-zA-Z_\-]+' /*post here is the name of our slug*/);
