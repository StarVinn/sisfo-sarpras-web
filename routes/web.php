<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;


// redirect login
Route::get('/', function () {
    return redirect()->route('login');
});

// Register & Login Routes
Route::group(['middleware' => 'guest'], function(){
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// middleware login
Route::middleware([RedirectIfAuthenticated::class])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
});
// logout 
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// User
Route::middleware(['auth'])->group(function () {
    Route::get('/user/home', function () {
        return view('user.home');
    })->name('user.home');

    Route::get('/user/barang', [
        \App\Http\Controllers\BarangController::class, 'indexuser'
    ])->name('user.barang');

    Route::get('/user/tentang-kami', function () {
        return view('user.tentang_kami');
    })->name('user.tentang_kami');

    Route::get('/user/hubungi-kami', function () {
        return view('user.hubungi_kami');
    })->name('user.hubungi-kami');

    Route::get('/user/peminjaman/riwayat', [PeminjamanController::class, 'riwayatPeminjaman'])->name('user.peminjaman.riwayat');     
    Route::get('/user/peminjaman/pinjam', [PeminjamanController::class, 'create'])->name('user.peminjaman.pinjam');     
    Route::post('/user/peminjaman/pinjam', [PeminjamanController::class, 'pinjamBarang'])->name('user.peminjaman.pinjam.store');      
    Route::get('/user/pengembalian/form/{id}', [PeminjamanController::class, 'formPengembalian'])->name('user.pengembalian.form'); 
    Route::get('/user/pengembalian/{id}', [PeminjamanController::class, 'detailPengembalianUser'])->name('user.pengembalian.detail');    
    Route::post('/user/pengembalian/kembalikan/{id}', [PeminjamanController::class, 'kembalikanBarang'])->name('user.pengembalian.kembalikan'); 
    Route::get('/user/peminjaman/ditolak/{id}', [PeminjamanController::class, 'userRejectedPeminjamanDetail'])->name('user.peminjaman.ditolak');
    
});

// Admin Dashboard
Route::middleware([AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.index');
    // Remove the existing /admin/barang route returning view
    Route::get('/user/export', [\App\Http\Controllers\UserController::class, 'export'])->name('admin.user.export');
    // Add individual routes for BarangController
    Route::get('/barang', [\App\Http\Controllers\BarangController::class, 'index'])->name('admin.barang.index');
    Route::get('/barang/export', [\App\Http\Controllers\BarangController::class, 'export'])->name('admin.barang.export');
    Route::get('/barang/create', [\App\Http\Controllers\BarangController::class, 'create'])->name('admin.barang.create');
    Route::post('/barang', [\App\Http\Controllers\BarangController::class, 'store'])->name('admin.barang.store');
    Route::get('/barang/{barang}/edit', [\App\Http\Controllers\BarangController::class, 'edit'])->name('admin.barang.edit');
    Route::put('/barang/{barang}', [\App\Http\Controllers\BarangController::class, 'update'])->name('admin.barang.update');
    Route::get('/barang/{barang}', [\App\Http\Controllers\BarangController::class, 'show'])->name('admin.barang.show');
    Route::delete('/barang/{barang}', [\App\Http\Controllers\BarangController::class, 'destroy'])->name('admin.barang.destroy');
    
    // Category CRUD routes
    Route::get('/category', [\App\Http\Controllers\CategoryController::class, 'index'])->name('admin.category.index');
    Route::get('/category/export', [\App\Http\Controllers\CategoryController::class, 'export'])->name('admin.category.export');
    Route::get('/category/create', [\App\Http\Controllers\CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/category', [\App\Http\Controllers\CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('/category/{category}', [\App\Http\Controllers\CategoryController::class, 'show'])->name('admin.category.show');
    Route::get('/category/{category}/edit', [\App\Http\Controllers\CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::put('/category/{category}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('admin.category.update');
    Route::delete('/category/{category}', [\App\Http\Controllers\CategoryController::class, 'destroy'])->name('admin.category.destroy');

    // Peminjaman CRUD routes
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('admin.peminjaman.index');  
    Route::get('/peminjaman/export', [PeminjamanController::class, 'export'])->name('admin.peminjaman.export');  
    Route::get('/peminjaman/form-tolak/{id}', [PeminjamanController::class, 'formTolak'])->name('admin.peminjaman.form-tolak');
    Route::post('/peminjaman/tolak-pinjam/{id}', [PeminjamanController::class, 'tolakPinjam'])->name('admin.peminjaman.tolak-pinjam'); 
    Route::post('/peminjaman/tolak-kembali/{id}', [PeminjamanController::class, 'tolakKembali'])->name('admin.peminjaman.tolak-kembali');
    Route::post('/peminjaman/konfirmasi-pinjam/{id}', [PeminjamanController::class, 'konfirmasiPinjam'])->name('admin.peminjaman.konfirmasi-pinjam');     
    Route::post('/peminjaman/konfirmasi-kembali/{id}', [PeminjamanController::class, 'konfirmasiPengembalian'])->name('admin.peminjaman.konfirmasi-kembali');     
    Route::get('/pengembalian/{id}', [PeminjamanController::class, 'detailPengembalian'])->name('admin.pengembalian.detail'); 
    Route::get('/pengembalian/{id}/denda', [PeminjamanController::class, 'formDenda'])->name('admin.pengembalian.form-denda');
    Route::post('/pengembalian/{id}/denda', [PeminjamanController::class, 'applyDenda'])->name('admin.pengembalian.applyDenda');
    Route::post('/pengembalian/{id}/hapus-denda', [PeminjamanController::class, 'removeDenda'])->name('admin.pengembalian.removeDenda');

    // Denda CRUD routes
    Route::get('/denda', [DendaController::class, 'index'])->name('admin.denda.index');
    Route::get('/denda/create', [DendaController::class, 'create'])->name('admin.denda.form-create');
    Route::post('/denda', [DendaController::class, 'store'])->name('admin.denda.store');
    Route::get('/denda/{denda}/edit', [DendaController::class, 'edit'])->name('admin.denda.form-edit');
    Route::put('/denda/{denda}', [DendaController::class, 'update'])->name('admin.denda.update');
    Route::delete('/denda/{denda}', [DendaController::class, 'destroy'])->name('admin.denda.delete');

    // tolak peminjaman
    Route::get('/peminjaman/ditolak/{id}', [PeminjamanController::class, 'rejectedPeminjaman'])->name('admin.peminjaman.ditolak');
});
