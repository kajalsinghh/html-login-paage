<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', [UserController::class, 'index']);
Route::get('/register', [UserController::class, 'register']);
Route::get('/forgot', [UserController::class, 'forgot']);
Route::get('/reset', [UserController::class, 'reset']);

Route::post('/register', [UserController::class, 'saveUser'])->name('exam.register');
Route::post('/login', [UserController::class, 'loginUser'])->name('exam.login');

Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::get('/logout', [UserController::class, 'logout'])->name('exam.logout');

Route::group(['middleware' => ['LoginCheck']], function (){
    Route::get('/   ', [UserController::class, 'index']);
    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/logout', [UserController::class, 'logout'])->name('exam.logout');
    Route::post('/profile-image', [UserController::class, 'profileImageUpdate'])->name('profile.image');
    Route::post('/profile-update', [UserController::class, 'profileUpdate'])->name('profile.update');

});
