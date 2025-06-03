<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JamuController;
use App\Http\Controllers\SmartController;
use App\Http\Controllers\UserPreferenceController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Jamu routes
// Jamu routes
Route::prefix('jamu')->name('jamu.')->group(function () {
    Route::get('/', [JamuController::class, 'index'])->name('index');
    Route::get('/compare', [JamuController::class, 'compare'])->name('compare');
    Route::get('/search', [JamuController::class, 'search'])->name('search');
    Route::get('/{id}', [JamuController::class, 'show'])->name('show');
    Route::get('/category/{category}', [JamuController::class, 'category'])->name('category');
});

// SMART Algorithm routes
Route::prefix('smart')->name('smart.')->group(function () {
    Route::get('/', [SmartController::class, 'index'])->name('index');
    Route::post('/calculate', [SmartController::class, 'calculate'])->name('calculate');
    Route::post('/compare', [SmartController::class, 'compare'])->name('compare');
});

// Article routes
Route::prefix('articles')->name('articles.')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->name('index');
    Route::get('/{slug}', [ArticleController::class, 'show'])->name('show');
    Route::get('/category/{category}', [ArticleController::class, 'category'])->name('category');
});

// User authenticated routes
Route::middleware('auth')->group(function () {
    // User dashboard
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');

    // User preferences
    Route::prefix('preferences')->name('preferences.')->group(function () {
        Route::get('/', [UserPreferenceController::class, 'index'])->name('index');
        Route::post('/', [UserPreferenceController::class, 'store'])->name('store');
    });

    // Search history
    Route::prefix('search-history')->name('search-history.')->group(function () {
        Route::get('/', [UserPreferenceController::class, 'history'])->name('index');
        Route::delete('/{id}', [UserPreferenceController::class, 'deleteHistory'])->name('destroy');
        Route::delete('/', [UserPreferenceController::class, 'clearHistory'])->name('clear');
    });

    // Favorites
    Route::prefix('favorites')->name('favorites.')->group(function () {
        Route::get('/', [FavoriteController::class, 'index'])->name('index');
        Route::post('/', [FavoriteController::class, 'store'])->name('store');
        Route::post('/toggle', [FavoriteController::class, 'toggle'])->name('toggle');
        Route::post('/toggle/{jamuId}', [FavoriteController::class, 'toggle'])->name('toggle.id');
        Route::delete('/{jamuId}', [FavoriteController::class, 'destroy'])->name('destroy');
    });

    // Profile
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Jamu management
    Route::prefix('jamu')->name('jamu.')->group(function () {
        Route::get('/', [AdminController::class, 'jamus'])->name('index');
        Route::get('/create', [AdminController::class, 'createJamu'])->name('create');
        Route::post('/', [AdminController::class, 'storeJamu'])->name('store');
        Route::get('/{id}/edit', [AdminController::class, 'editJamu'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'updateJamu'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'destroyJamu'])->name('destroy');
        Route::post('/bulk', [AdminController::class, 'bulkJamu'])->name('bulk');
    });

    // Article management
    Route::prefix('articles')->name('articles.')->group(function () {
        Route::get('/', [AdminController::class, 'articles'])->name('index');
        Route::get('/create', [AdminController::class, 'createArticle'])->name('create');
        Route::post('/', [AdminController::class, 'storeArticle'])->name('store');
        Route::get('/{id}/edit', [AdminController::class, 'editArticle'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'updateArticle'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'destroyArticle'])->name('destroy');
    });

    // User management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminController::class, 'users'])->name('index');
    });

    // Analytics
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
});

// Auth routes
require __DIR__ . '/auth.php';
