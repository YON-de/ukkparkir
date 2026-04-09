<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Petugas\TransaksiController;
use App\Http\Controllers\Petugas\DashboardController;
// Root redirect ke login
Route::get('/', fn() => redirect()->route('login'));

// Setelah login, redirect berdasarkan role
Route::middleware('auth')->get('/dashboard', function () {
    return match(auth()->user()->role) {
        'admin'   => redirect()->route('admin.dashboard'),
        'petugas' => redirect()->route('petugas.dashboard'),
        'owner'   => redirect()->route('owner.dashboard'),
        default   => abort(403),
    };
})->name('dashboard');

// ─── ADMIN ────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('users',     \App\Http\Controllers\Admin\UserController::class);
        Route::resource('tarif',     \App\Http\Controllers\Admin\TarifController::class);
        Route::resource('area',      \App\Http\Controllers\Admin\AreaController::class);
        Route::resource('kendaraan', \App\Http\Controllers\Admin\KendaraanController::class);
        Route::get('log',            [\App\Http\Controllers\Admin\LogController::class, 'index'])->name('log.index');
    });

// ─── PETUGAS ──────────────────────────────────────────
Route::prefix('petugas')
    ->middleware(['auth', 'role:petugas'])
    ->name('petugas.')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/ai', [DashboardController::class, 'ai'])->name('ai');
        Route::get('/transaksi', [TransaksiController::class, 'index'])
            ->name('transaksi');

        Route::post('/masuk', [TransaksiController::class, 'masuk'])
            ->name('masuk'); 

        Route::post('/keluar', [TransaksiController::class, 'keluar'])
            ->name('keluar'); 

        Route::get('/struk/{id}', [TransaksiController::class, 'struk'])
            ->name('struk');

        Route::get('/struk-masuk/{id}', [TransaksiController::class, 'strukMasuk'])
            ->name('struk.masuk');
});
// ─── OWNER ────────────────────────────────────────────
Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {
        Route::get('/',     [\App\Http\Controllers\Owner\DashboardController::class, 'index'])->name('dashboard');
        Route::get('rekap', [\App\Http\Controllers\Owner\RekapController::class, 'index'])->name('rekap');
    });

// Auth routes (login, logout — dari Breeze)
require __DIR__.'/auth.php';