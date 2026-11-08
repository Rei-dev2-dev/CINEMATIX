<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FilmController;
use Illuminate\Support\Facades\Route;

// 1. Home / Katalog
Route::get('/', [FilmController::class, 'index'])->name('home');

// 2. Detail Film
Route::get('/film/{id}', [FilmController::class, 'show'])->name('film.show');

// 3. Booking / Pemilihan Kursi
Route::get('/booking/{schedule_id}', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking/{schedule_id}', [BookingController::class, 'store'])->name('booking.store');

// 4. E-Ticket
Route::get('/tiket/{kode_booking}', [BookingController::class, 'showTicket'])->name('tiket.show');

// 5. Cari Tiket Saya
Route::get('/tiket-saya', [BookingController::class, 'searchTicket'])->name('tiket.search');

// 6. Admin Panel
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    
    // Kelola Film
    Route::get('/films', [AdminController::class, 'films'])->name('films');
    Route::post('/films', [AdminController::class, 'storeFilm'])->name('films.store');
    Route::put('/films/{id}', [AdminController::class, 'updateFilm'])->name('films.update');
    Route::delete('/films/{id}', [AdminController::class, 'deleteFilm'])->name('films.delete');
    
    // Kelola Jadwal
    Route::get('/schedules', [AdminController::class, 'schedules'])->name('schedules');
    Route::post('/schedules', [AdminController::class, 'storeSchedule'])->name('schedules.store');
    Route::delete('/schedules/{id}', [AdminController::class, 'deleteSchedule'])->name('schedules.delete');
    
    // Laporan Pemesanan
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
});
