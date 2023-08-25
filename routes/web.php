<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/dashboard', DashboardController::class)->name('dashboard')->middleware('admin');
    Route::group(['middleware' => 'admin', 'prefix' => 'dashboard'], function () {
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('users/export', [UserController::class, 'export'])->name('user.export');
        Route::resource('users', UserController::class, [
            'names' => [
                'index' => 'users',
            ],
        ]);
    });


    Route::resource('complaints', ComplaintController::class);
    Route::get('reload-captcha', [ComplaintController::class, 'reloadCaptcha'])->name('reload-captcha');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
