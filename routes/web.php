<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Client\AppointmentController as ClientAppointmentController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\UserController;

// ─── Public Routes ───────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// ─── Auth Routes (Breeze) ────────────────────────────────────
require __DIR__.'/auth.php';

// ─── Client Routes ───────────────────────────────────────────
Route::middleware(['auth'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/appointments', [ClientAppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [ClientAppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [ClientAppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}', [ClientAppointmentController::class, 'show'])->name('appointments.show');
    Route::patch('/appointments/{appointment}/cancel', [ClientAppointmentController::class, 'cancel'])->name('appointments.cancel');
});

// ─── Admin Routes ────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/appointments', [AdminAppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/{appointment}', [AdminAppointmentController::class, 'show'])->name('appointments.show');
    Route::patch('/appointments/{appointment}/status', [AdminAppointmentController::class, 'updateStatus'])->name('appointments.status');

    Route::resource('services', ServiceController::class);
    Route::resource('users', UserController::class);
});