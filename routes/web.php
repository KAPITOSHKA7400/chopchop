<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware(['auth']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [DashboardController::class, 'store']);
    Route::delete('/dashboard/bot/{bot}', [DashboardController::class, 'destroy'])->name('bot.destroy');
});


Route::get('/chats', function () {
    return view('chats');
})->middleware(['auth']);

// Остальные страницы для Настроек по желанию
Route::get('/profile', function () {
    return view('profile');
})->middleware(['auth']);

Route::get('/statistics', function () {
    return view('statistics');
})->middleware(['auth']);

Route::get('/security', function () {
    return view('security');
})->middleware(['auth']);

Route::get('/faq', function () {
    return view('faq');
})->middleware(['auth']);



require __DIR__.'/auth.php';
