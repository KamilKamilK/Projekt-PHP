<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


//Route::get('/', function () {
//    return view('home.index', []);
//})->name('home.index');
//
//Route::get('/contact', function () {
//    return view('home.contact');
//})->name('home.contact');


Route::get('/', [HomeController::class,'home'])
    ->name('home')
//    ->middleware('auth');
;
Route::get('/contact', [HomeController::class,'contact'])->name('contact');
Route::get('/secret', [HomeController::class,'secret'])
    ->name('secret')
    ->middleware('can:home.secret');

Route::resource('posts', PostsController::class);
//    ->only(['index', 'show','create','store','edit', 'update',]);


Auth::routes();




//Route::get('single', AboutController::class);

//Route::get('/posts', function () use ($posts) {
////    dd(request()->all());
////    dd((int)request()->query('page', 1));
//    return view('posts.index', ['posts' => $posts]);
////   return view('posts.index',compact( $posts));
//});
//Route::get('/posts/{id}', function ($id) use ($posts) {
//    abort_if(!isset($posts[$id]), 404);
//    return view('posts.show', ['post' => $posts[$id]]);
//})
////->where([
////    'id'=>'[0-9]+'
////])
//    ->name('posts.show');




//Route::get('/recent-posts/{days_ago?}', function ($daysAgo = 20) {
//    return 'Posts from ' . $daysAgo . ' days ago';
//})->name('posts.recent.index')->middleware('auth');
//
//
//Route::prefix('/fun')->name('fun.')->group(function () use ($posts) {
//
//    Route::get('responses', function () use ($posts) {
//        return response($posts, 201)
//            ->header('Content-Type', 'application/json')
//            ->cookie('MY_COOKIE', 'Kamil Kaczmarek', 3600);
//    })->name('responses');
//
//    Route::get('redirect', function () {
//        return redirect('/contact');
//    })->name('redirect');
//
//    Route::get('back', function () {
//        return back();
//    })->name('back');
//
//    Route::get('named-route', function () {
//        return redirect()->route('posts.show', ['id' => 1]);
//    })->name('named-route');
//
//    Route::get('away', function () {
//        return redirect()->away('https://google.com');
//    })->name('away');
//
//    Route::get('json', function () use ($posts) {
//        return response()->json($posts);
//    })->name('json');
//
//    Route::get('download', function () use ($posts) {
//        return response()->download(public_path('kozak.jpg'), ' costume.jpg');
//    })->name('download');
//});

