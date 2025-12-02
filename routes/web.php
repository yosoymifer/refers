<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('influencer.dashboard');
    })->name('dashboard');

    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        
        Route::get('/influencers', function () {
            return view('admin.influencers');
        })->name('influencers');
        
        Route::get('/qr-scanner', function () {
            return view('admin.qr-scanner');
        })->name('qr-scanner');
        
        Route::get('/change-password', function () {
            return view('admin.change-password');
        })->name('change-password');
        
        Route::get('/leads', function () {
            return view('admin.leads');
        })->name('leads');
    });

    // Influencer routes
    Route::middleware('influencer')->prefix('influencer')->name('influencer.')->group(function () {
        Route::get('/dashboard', function () {
            return view('influencer.dashboard');
        })->name('dashboard');
    });
});

// Public landing page for leads
Route::get('/r/{code}', [App\Http\Controllers\LandingController::class, 'show'])->name('landing.register');
Route::post('/r/{code}', [App\Http\Controllers\LandingController::class, 'register'])->name('landing.register.post');
Route::get('/download-qr/{code}', [App\Http\Controllers\LandingController::class, 'downloadQr'])->name('landing.download-qr');
