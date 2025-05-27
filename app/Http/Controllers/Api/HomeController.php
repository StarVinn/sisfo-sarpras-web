<?php

namespace App\Http\Controllers\Api;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // menampilkan data barang yang ada, peminjaman yang user pernah lakukan, dan pengembalian yang user lakukan
        $peminjaman = Peminjaman::with('user')->where('user_id', auth()->user()->id)->get();
        $barang = Barang::all();
        return response()->json([
            'peminjaman' => $peminjaman,
            'barang' => $barang,
        ]);
    }
}
