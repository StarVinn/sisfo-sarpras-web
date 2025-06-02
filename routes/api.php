<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\API\PeminjamanController;

// Route Mobile User
Route::middleware(['auth:sanctum','cors'])->group(function () {
    // GET /api/dashboard → menampilkan data user
    Route::get('/home', [HomeController::class, 'index']);

    // GET /api/barang → daftar semua barang
    Route::get('/barang', [BarangController::class, 'indexmobile']);

    // POST /api/barang → simpan barang baru
    Route::post('/barang', [BarangController::class, 'store']);

    // GET /api/barang/{barang} → detail barang tertentu
    Route::get('/barang/{barang}', [BarangController::class, 'show']);
    
    Route::get('/peminjaman', [PeminjamanController::class, 'index']); // admin
    Route::get('/peminjaman/riwayat', [PeminjamanController::class, 'riwayatPeminjaman']); // user
    Route::post('/peminjaman', [PeminjamanController::class, 'pinjamBarang']); // user
    Route::post('/peminjaman/{id}/konfirmasi', [PeminjamanController::class, 'konfirmasiPinjam']); // admin
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'detailPeminjaman']); // user

    Route::post('/pengembalian/{id}', [PeminjamanController::class, 'kembalikanBarang']); // user
    Route::post('/pengembalian/{id}/konfirmasi', [PeminjamanController::class, 'konfirmasiPengembalian']); // admin
    Route::get('/pengembalian/{id}', [PeminjamanController::class, 'detailPengembalian']); // admin
});
// api barangs data table
Route::apiResource('barangs', BarangController::class);
// api login dan logout mobile
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
