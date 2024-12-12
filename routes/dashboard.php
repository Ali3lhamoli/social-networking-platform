<?php

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\PostController;

Route::prefix('admin')->as('admin.')->group(function(){
    Route::middleware(['dashbourd'])->group(function(){

        Route::get('/', DashboardController::class)->name('dashboard');
        Route::post('/logout', LogoutController::class)->name('auth.logout');

        Route::resource('users',UserController::class);
        Route::resource('posts',PostController::class)->only('index', 'show', 'destroy');

    });
    
});