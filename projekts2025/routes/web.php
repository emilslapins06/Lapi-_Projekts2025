<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;

use Illuminate\Support\Facades\Route;

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/home', function () {
    return view('dashboard.home');
})->name('home')->middleware('auth');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/karte', function () {
    return view('dashboard.karte');
})->middleware('auth')->name('karte');
Route::get('/api/locations', [App\Http\Controllers\MapController::class, 'fetchLocations']);

Route::get('/admin', [AdminController::class, 'index'])->middleware('auth')->name('admin');

Route::delete('/admin/users/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('admin.deleteUser');

Route::get('/calendar', function () {
    return view('dashboard.calendar');
})->name('calendar')->middleware('auth');

Route::get('/api/events', [App\Http\Controllers\EventController::class, 'fetchEvents']);
Route::post('/api/events', [App\Http\Controllers\EventController::class, 'store']);