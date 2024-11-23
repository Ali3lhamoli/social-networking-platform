<?php

use App\Http\Controllers\Site\ConnectionController;
use App\Http\Controllers\Site\SearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\PostController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\ProfileController;
use App\Http\Controllers\Site\Auth\LoginController;
use App\Http\Controllers\Site\Auth\LogoutController;
use App\Http\Controllers\Site\Auth\RegisterController;
use App\Http\Controllers\Site\CommentController;
use App\Http\Controllers\Site\LikeController;
use App\Http\Controllers\Site\SettingController;

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


Route::as('site.')->group(function () {

    Route::middleware('auth')->group(function () {
        Route::post('/logout', LogoutController::class)->name('logout');

        Route::get('/profile', ProfileController::class)->name('profile');

        Route::post('/search', SearchController::class)->name('search');


        Route::controller(PostController::class)->group(function () {
            Route::post('/post', 'store')->name('post.store');
            Route::delete('/post/{post_id}', 'destroy')->name('post.destroy');
            Route::get('/post/{post_id}/edit', 'edit')->name('post.edit');
            Route::put('/post/{post_id}', 'update')->name('post.update');
        });

        Route::controller(SettingController::class)->group(function () {
            Route::get('/settings', 'index')->name('settings.index');
            Route::put('/settings/account', 'account_settings')->name('settings.account.update');
            Route::put('/settings/security', 'security_settings')->name('settings.security.update');
            Route::put('/settings/picture', 'profile_picture')->name('settings.picture.update');

        });

        Route::resource('comments', CommentController::class)->only('store', 'update', 'destroy');
        Route::resource('likes', LikeController::class)->only('store', 'destroy');
        Route::resource('connections', ConnectionController::class)->except('adit');

    });



    Route::controller(PostController::class)->group(function () {
        Route::get('/post', 'show')->name('post');
    });
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/fetch-posts', 'fetchPosts')->name('posts.fetch');
    });
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'show')->name('login.show');
        Route::post('/login', 'authenticate')->name('login.authenticate');
    });

    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'show')->name('register.show');
        Route::post('/register', 'register')->name('register.store');
    });
});

