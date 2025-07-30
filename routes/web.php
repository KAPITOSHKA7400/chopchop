<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\BotInviteController;

Route::get('/', function () {
    return view('welcome');
});

// Группа для dashboard — защищена middleware 'auth'
Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/', [DashboardController::class, 'store']);
    Route::delete('/bot/{bot}', [DashboardController::class, 'destroy'])->name('bot.destroy');
    // --- УБЕРИ ОТСЮДА ЭТУ СТРОКУ ---
    // Route::get('/chats', [ChatController::class, 'index'])->name('dashboard.chats');
});

// Остальные страницы профиля и настроек
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/statistics', function () { return view('statistics'); });
    Route::get('/security', function () { return view('security'); });
    Route::get('/faq', function () { return view('faq'); });
});

// маршруты приглашения к боту
Route::middleware(['auth'])->group(function () {
    Route::post('/bots/invite/join', [BotInviteController::class, 'join'])->name('bots.invite.join');
    Route::post('/bots/invite/generate', [BotInviteController::class, 'generate'])->name('bots.invite.generate');
});

// --- ОСТАВЬ ТОЛЬКО ЭТОТ GET-МАРШРУТ ДЛЯ ЧАТОВ! ---
Route::get('/dashboard/chats', [\App\Http\Controllers\ChatController::class, 'index'])
    ->name('dashboard.chats');
Route::aliasMiddleware('chats.index', 'dashboard.chats');

Route::post('/dashboard/chats/send', [ChatController::class, 'send'])->name('chats.send');
Route::delete('/dashboard/chats/message/{id}', [ChatController::class, 'delete'])->name('chats.delete');
Route::post('/dashboard/chats/message/{id}/edit', [ChatController::class, 'edit'])->name('chats.edit');

// в web.php
Route::get('/dashboard/chats/list', [ChatController::class, 'chatList'])->name('dashboard.chats.list');
Route::get('/dashboard/chats/messages', [ChatController::class, 'chatMessages'])->name('dashboard.chats.messages');


require __DIR__.'/auth.php';
