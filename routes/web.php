<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('events.index') : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::resource('eventos', EventController::class)
        ->only(['index', 'show'])
        ->parameters(['eventos' => 'event'])
        ->names('events');

    Route::post('/eventos/{event}/inscricoes', [RegistrationController::class, 'store'])
        ->name('registrations.store');
        
    Route::get('/minhas-inscricoes', [RegistrationController::class, 'index'])
        ->name('registrations.index');
        
    Route::delete('/inscricoes/{registration}', [RegistrationController::class, 'destroy'])
        ->name('registrations.destroy');

    Route::middleware('admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::resource('categories', AdminCategoryController::class);
            
            Route::get('/events/{event}/participants', [AdminEventController::class, 'participants'])
                ->name('events.participants');
                
            Route::resource('events', AdminEventController::class)
                ->except(['show']);
        });
});