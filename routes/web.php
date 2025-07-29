<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChatController; // Добавь этот контроллер

Route::get('/', function () {
    return view('welcome');
});

// Группа для dashboard — защищена middleware 'auth'
Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/', [DashboardController::class, 'store']);
    Route::delete('/bot/{bot}', [DashboardController::class, 'destroy'])->name('bot.destroy');

    // Страница чатов
    Route::get('/chats', [ChatController::class, 'index'])->name('dashboard.chats');
    // Если нужно будет добавлять чаты — тут же POST, DELETE и т.д.
});

// Остальные страницы профиля и настроек
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/statistics', function () {
        return view('statistics');
    });

    Route::get('/security', function () {
        return view('security');
    });

    Route::get('/faq', function () {
        return view('faq');
    });
});

require __DIR__.'/auth.php';
