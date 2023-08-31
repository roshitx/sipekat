<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResponController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

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
Route::get('/', WelcomeController::class)->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('admin');
    Route::resource('respons', ResponController::class);

    Route::group(['middleware' => 'admin', 'prefix' => 'dashboard'], function () {
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('users/export', [UserController::class, 'export'])->name('user.export');
        Route::resource('users', UserController::class, [
            'names' => [
                'index' => 'users',
            ],
            'except' => ['show']
        ]);
    });
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');


    Route::resource('complaints', ComplaintController::class)->except(['show', 'edit']);
    // Sluggable complaints route url
    Route::get('complaints/{slug}', [ComplaintController::class, 'show'])->name('complaints.show');
    Route::get('complaints/{slug}/edit', [ComplaintController::class, 'edit'])->name('complaints.edit');;

    Route::get('reload-captcha', [ComplaintController::class, 'reloadCaptcha'])->name('reload-captcha');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('gender-chart', [DashboardController::class, 'genderChart']);

require __DIR__.'/auth.php';
