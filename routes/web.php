<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeknisiController;
use App\Http\Controllers\Manager\PegawaiController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('/manager/dashboard', [\App\Http\Controllers\Manager\DashboardController::class, 'index'])->name('manager.dashboard');
    Route::get('/manager/history', [\App\Http\Controllers\Manager\DashboardController::class, 'history'])->name('manager.history');
    Route::get('/manager/history/{id}', [\App\Http\Controllers\Manager\DashboardController::class, 'show'])->name('manager.show');
    
    Route::get('/teknisi/dashboard', [TeknisiController::class, 'dashboard'])->name('teknisi.dashboard');
    Route::get('/add-data', [TeknisiController::class, 'create'])->name('teknisi.create');
    Route::post('/add-data', [TeknisiController::class, 'store'])->name('teknisi.store');
    Route::get('/history', [TeknisiController::class, 'index'])->name('teknisi.history');
    Route::get('/history/{activity}', [TeknisiController::class, 'show'])->name('teknisi.show');
    Route::get('/history/{activity}/edit', [TeknisiController::class, 'edit'])->name('teknisi.edit');
    Route::put('/history/{activity}', [TeknisiController::class, 'update'])->name('teknisi.update');
    Route::delete('/history/{activity}', [TeknisiController::class, 'destroy'])->name('teknisi.destroy');

    Route::get('/', function () {
        if (Auth::user()->role === 'manager') {
            return redirect()->route('manager.dashboard');
        }
        return redirect()->route('teknisi.dashboard');
    });

    Route::get('/manager/tambah-data-pegawai', [PegawaiController::class, 'create'])
    ->name('manager.tambahdatapegawai');

    Route::post('/manager/tambah-data-pegawai', [PegawaiController::class, 'store'])
        ->name('manager.storepegawai');

    // Pastikan diletakkan di dalam middleware 'auth'
    Route::delete('/manager/pegawai/delete/{id}', [PegawaiController::class, 'destroy'])
        ->name('manager.hapuspegawai'); // Saya ubah namanya agar unik dan jelas
});