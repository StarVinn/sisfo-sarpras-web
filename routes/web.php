<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BarangController;
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
        BarangController::class, 'indexuser'
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

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    Route::get('/', [DashboardController::class, 'index'])->name('admin.index');
    Route::get('/user/export', [\App\Http\Controllers\UserController::class, 'export'])->name('admin.user.export');

    // Route Prefix Barang
    Route::prefix('barang')->group(function (){
        Route::get('/', [BarangController::class, 'index'])->name('admin.barang.index');
        Route::get('/export', [BarangController::class, 'export'])->name('admin.barang.export');
        Route::get('/create', [BarangController::class, 'create'])->name('admin.barang.create');
        Route::post('/', [BarangController::class, 'store'])->name('admin.barang.store');
        Route::get('/{barang}/edit', [BarangController::class, 'edit'])->name('admin.barang.edit');
        Route::put('/{barang}', [BarangController::class, 'update'])->name('admin.barang.update');
        Route::get('/{barang}', [BarangController::class, 'show'])->name('admin.barang.show');
        Route::delete('/{barang}', [BarangController::class, 'destroy'])->name('admin.barang.destroy');
    });
    
    // Category CRUD routes
    Route::prefix('category')->group(function (){
        Route::get('/', [\App\Http\Controllers\CategoryController::class, 'index'])->name('admin.category.index');
        Route::get('/export', [\App\Http\Controllers\CategoryController::class, 'export'])->name('admin.category.export');
        Route::get('/create', [\App\Http\Controllers\CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('/', [\App\Http\Controllers\CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('/{category}', [\App\Http\Controllers\CategoryController::class, 'show'])->name('admin.category.show');
        Route::get('/{category}/edit', [\App\Http\Controllers\CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::put('/{category}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/{category}', [\App\Http\Controllers\CategoryController::class, 'destroy'])->name('admin.category.destroy');
    });

    // Peminjaman CRUD routes
    Route::prefix('peminjaman')->group(function (){
        Route::get('/', [PeminjamanController::class, 'index'])->name('admin.peminjaman.index');  
        Route::get('/export', [PeminjamanController::class, 'export'])->name('admin.peminjaman.export');  
        Route::get('/form-tolak/{id}', [PeminjamanController::class, 'formTolak'])->name('admin.peminjaman.form-tolak');
        Route::post('/tolak-pinjam/{id}', [PeminjamanController::class, 'tolakPinjam'])->name('admin.peminjaman.tolak-pinjam'); 
        Route::post('/tolak-kembali/{id}', [PeminjamanController::class, 'tolakKembali'])->name('admin.peminjaman.tolak-kembali');
        Route::post('/konfirmasi-pinjam/{id}', [PeminjamanController::class, 'konfirmasiPinjam'])->name('admin.peminjaman.konfirmasi-pinjam');     
        Route::post('/konfirmasi-kembali/{id}', [PeminjamanController::class, 'konfirmasiPengembalian'])->name('admin.peminjaman.konfirmasi-kembali'); 
        Route::get('/ditolak/{id}', [PeminjamanController::class, 'rejectedPeminjaman'])->name('admin.peminjaman.ditolak');    
    });
    Route::prefix('pengembalian')->group(function (){
        Route::get('/{id}', [PeminjamanController::class, 'detailPengembalian'])->name('admin.pengembalian.detail'); 
        Route::get('/{id}/denda', [PeminjamanController::class, 'formDenda'])->name('admin.pengembalian.form-denda');
        Route::post('/{id}/denda', [PeminjamanController::class, 'applyDenda'])->name('admin.pengembalian.applyDenda');
        Route::post('/{id}/hapus-denda', [PeminjamanController::class, 'removeDenda'])->name('admin.pengembalian.removeDenda');
    });

    // Denda CRUD routes
    Route::prefix('denda')->group(function (){
        Route::get('/', [DendaController::class, 'index'])->name('admin.denda.index');
        Route::get('/create', [DendaController::class, 'create'])->name('admin.denda.form-create');
        Route::post('/', [DendaController::class, 'store'])->name('admin.denda.store');
        Route::get('/{denda}/edit', [DendaController::class, 'edit'])->name('admin.denda.form-edit');
        Route::put('/{denda}', [DendaController::class, 'update'])->name('admin.denda.update');
        Route::delete('/{denda}', [DendaController::class, 'destroy'])->name('admin.denda.delete');
    });

    
});
