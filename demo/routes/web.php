<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamFormController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/teams/{team}/forms', [TeamFormController::class, 'index']);
    Route::post('/teams/{team}/forms', [TeamFormController::class, 'store']);
});
