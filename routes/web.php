<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    SongController,
    PlaylistController,
    FeedbackController,
    MusicController,
    UserController,
    HomeController
};

// ✅ Auth Controllers
use App\Http\Controllers\Auth\{
    LoginController,
    RegisterController
};

// ✅ Admin Controllers
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/songs', [SongController::class, 'index'])->name('songs.index');
Route::get('/songs/{song}', [SongController::class, 'show'])->name('songs.show');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Song Management (excluding public index/show)
    Route::resource('songs', SongController::class)->except(['index', 'show']);

    // Playlist Management
    Route::resource('playlists', PlaylistController::class);

    // Playlist Songs Management
    Route::post('/playlists/{playlist}/songs', [PlaylistController::class, 'addSong'])->name('playlists.songs.add');
    Route::delete('/playlists/{playlist}/songs', [PlaylistController::class, 'removeSong'])->name('playlists.songs.remove');
    Route::put('/playlists/{playlist}/songs/reorder', [PlaylistController::class, 'reorderSongs'])->name('playlists.songs.reorder');

    // ✅ User Feedback Submission
    Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Requires 'auth' + 'admin' middleware)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Feedback Management
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::get('/feedback/{feedback}', [FeedbackController::class, 'show'])->name('feedback.show');
    Route::put('/feedback/{feedback}', [FeedbackController::class, 'update'])->name('feedback.update');
    Route::delete('/feedback/{feedback}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');

    // Music Management
    Route::resource('music', MusicController::class)->except(['show']);

    // User Management
    Route::resource('users', UserController::class)->except(['show']);
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
});