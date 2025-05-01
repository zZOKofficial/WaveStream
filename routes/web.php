<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SongController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\UserController;

// ✅ Corrected: Admin Dashboard Controller namespace
use App\Http\Controllers\Admin\DashboardController;

// ✅ Auth Controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Default route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public routes
Route::get('/songs', [SongController::class, 'index'])->name('songs.index');
Route::get('/songs/{song}', [SongController::class, 'show'])->name('songs.show');

// Admin-only Feedback management
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::get('/admin/feedback/{feedback}', [FeedbackController::class, 'show'])->name('feedback.show');
    Route::put('/admin/feedback/{feedback}', [FeedbackController::class, 'update'])->name('feedback.update');
    Route::delete('/admin/feedback/{feedback}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');
});

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    // Song management (excluding public index/show)
    Route::resource('songs', SongController::class)->except(['index', 'show']);

    // Playlist management
    Route::resource('playlists', PlaylistController::class);

    // Playlist song management
    Route::post('/playlists/{playlist}/songs', [PlaylistController::class, 'addSong'])->name('playlists.songs.add');
    Route::delete('/playlists/{playlist}/songs', [PlaylistController::class, 'removeSong'])->name('playlists.songs.remove');
    Route::put('/playlists/{playlist}/songs/reorder', [PlaylistController::class, 'reorderSongs'])->name('playlists.songs.reorder');
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // ✅ Admin dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Music Management (admin only)
    Route::resource('music', MusicController::class)->except(['show']);

    // User Management (admin only)
    Route::resource('users', UserController::class)->except(['show']);
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
});
