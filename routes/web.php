<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConversationController;

Route::group(['prefix' => '/auth', 'as' => 'auth.'], function () {
    Route::middleware('guest')->get('/login', [AuthController::class, 'login'])->name('login');
    Route::middleware('guest')->post('/login', [AuthController::class, 'loginPost'])->name('login-post');
    Route::middleware('auth')->post('/logout', [AuthController::class, 'logoutPost'])->name('logout-post');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', fn() => redirect()->route('conversations.index'))->name('dashboard.index');
    Route::group(['prefix' => 'conversations', 'as' => 'conversations.'], function () {
        Route::get('/', [ConversationController::class, 'index'])->name('index');
        Route::get('/{conversation}', [ConversationController::class, 'show'])->name('show');

        Route::post('/{conversation}/messages', [ConversationController::class, 'sendMessage'])->name('send-message');
    });
});
