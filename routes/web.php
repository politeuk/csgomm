<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/login', [App\Http\Controllers\AuthController::class, 'steam'])->name('login');
Route::get('/steam/callback', [App\Http\Controllers\AuthController::class, 'callback'])->name('steam.callback');

Route::get('/connect/discord', [App\Http\Controllers\AuthController::class, 'discord'])->name('connect.discord');
Route::get('/discord/callback', [App\Http\Controllers\AuthController::class, 'discord_callback'])->name('discord.callback');

Route::post('/logout', [App\Http\Controllers\AuthController::class, 'destroy'])->name('logout');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/users', [App\Http\Controllers\UsersController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard.users');

Route::post('/queue', [App\Http\Controllers\QueueController::class, 'join'])->middleware(['auth', 'verified'])->name('dashboard.queue');
Route::delete('/queue', [App\Http\Controllers\QueueController::class, 'remove'])->middleware(['auth', 'verified'])->name('dashboard.queue.remove');
Route::post('/queue/ready', [App\Http\Controllers\QueueController::class, 'ready'])->middleware(['auth', 'verified'])->name('dashboard.queue.ready');

// require __DIR__.'/auth.php';
