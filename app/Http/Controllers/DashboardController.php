<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Barang;
use App\Models\Peminjaman; // Pastikan model ini ada
use App\Models\Pengembalian; // Pastikan model ini ada
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $barangCount = Barang::count();
    $kategoriCount = Category::count();
    $peminjamanCount = Peminjaman::count();
    $pengembalianCount = Pengembalian::count();

    // Ambil 6 bulan terakhir
    $months = collect(range(1, 12))->map(function($month) {
        return Carbon::create()->month($month)->format('F');
    });

    // Hitung jumlah peminjaman per bulan di tahun ini
    $peminjamanPerMonth = collect(range(1, 12))->map(function($month) {
        return Peminjaman::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', $month)
            ->count();
    });

    return view('admin.index', compact(
        'barangCount',
        'kategoriCount',
        'peminjamanCount',
        'pengembalianCount',
        'months',
        'peminjamanPerMonth'
    ));
}
}
