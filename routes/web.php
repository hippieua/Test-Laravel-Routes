<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/user/{name}', [UserController::class, 'show'])->name('users.show');
Route::view('/about', 'pages.about')->name('about');
Route::redirect('/log-in', '/login');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'app'], function () {
        Route::get('/dashboard', [DashboardController::class])->name('dashboard');
        Route::resource('/tasks', TaskController::class);
    });

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['is_admin']], function () {
        Route::get('/dashboard', AdminDashboardController::class);
        Route::get('/stats', StatsController::class);
    });
});
