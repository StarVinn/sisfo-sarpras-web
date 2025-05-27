<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamen = Peminjaman::with('user', 'barang')->get();
        return response()->json($peminjamen);
    }

    public function riwayatPeminjaman()
    {
        $user = Auth::user();
        $peminjamen = Peminjaman::where('user_id', $user->id)->with('barang', 'user')->get();
        return response()->json($peminjamen);
    }

    public function pinjamBarang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|exists:barangs,id',
            'kelas_peminjam' => 'required|string',
            'alasan_peminjam' => 'required|string',
            'tanggal_peminjaman' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();

        $peminjaman = Peminjaman::create([
            'user_id' => $user->id,
            'barang_id' => $request->barang_id,
            'kelas_peminjam' => $request->kelas_peminjam,
            'alasan_peminjam' => $request->alasan_peminjam,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'status' => 'waiting peminjaman',
        ]);

        return response()->json(['message' => 'Peminjaman berhasil diajukan', 'data' => $peminjaman], 201);
    }

    public function konfirmasiPinjam($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $barang = Barang::find($peminjaman->barang_id);

        if ($barang && $barang->quantity > 0) {
            $peminjaman->status = 'Dipinjam';
            $peminjaman->save();

            $barang->quantity -= 1;
            $barang->save();

            return response()->json(['message' => 'Peminjaman dikonfirmasi']);
        }

        return response()->json(['message' => 'Barang tidak tersedia'], 400);
    }

    public function detailPeminjaman($id)
    {
        $peminjaman = Peminjaman::with('barang')->findOrFail($id);
        return response()->json($peminjaman);
    }

    public function kembalikanBarang(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kondisi_barang' => 'required|string',
            'tanggal_dikembalikan' => 'required|date',
            'image_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $peminjaman = Peminjaman::findOrFail($id);

        $pengembalianData = [
            'peminjaman_id' => $peminjaman->id,
            'kondisi_barang' => $request->kondisi_barang,
            'tanggal_dikembalikan' => $request->tanggal_dikembalikan,
        ];

        if ($request->hasFile('image_bukti')) {
            $imagePath = $request->file('image_bukti')->store('bukti_pengembalian', 'public');
            $pengembalianData['image_bukti'] = $imagePath;
        }

        $existingPengembalian = Pengembalian::where('peminjaman_id', $peminjaman->id)->first();

        if ($existingPengembalian) {
            $existingPengembalian->update($pengembalianData);
        } else {
            Pengembalian::create($pengembalianData);
        }

        $peminjaman->status = 'waiting pengembalian';
        $peminjaman->save();

        return response()->json(['message' => 'Pengembalian berhasil diajukan']);
    }

    public function konfirmasiPengembalian($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = 'Dikembalikan';
        $peminjaman->alasan_penolakan = null;
        $peminjaman->save();

        $barang = Barang::find($peminjaman->barang_id);
        if ($barang) {
            $barang->quantity += 1;
            $barang->save();
        }

        return response()->json(['message' => 'Pengembalian dikonfirmasi']);
    }

    public function detailPengembalian($id)
    {
        $pengembalian = Pengembalian::where('peminjaman_id', $id)
            ->with('peminjaman.user', 'peminjaman.barang','denda')
            ->firstOrFail();

        if (!$pengembalian) {
            return response()->json(['data' => null]);
        }

        return response()->json(['data' => $pengembalian]);
    }

    public function tolakPinjam(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'alasan_penolakan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $peminjaman = Peminjaman::findOrFail($id);

        if (!in_array($peminjaman->status, ['waiting peminjaman', 'waiting pengembalian'])) {
            return response()->json(['message' => 'Peminjaman tidak dapat ditolak.'], 400);
        }

        // Separate rejection status
        if ($peminjaman->status == 'waiting peminjaman') {
            $peminjaman->status = 'peminjaman ditolak';
        } elseif ($peminjaman->status == 'waiting pengembalian') {
            $peminjaman->status = 'pengembalian ditolak';
        }
        $peminjaman->alasan_penolakan = $request->alasan_penolakan;
        $peminjaman->save();

        return response()->json(['message' => 'Peminjaman berhasil ditolak.']);
    }

    // Method for peminjaman ulang (re-loan)
    public function peminjamanUlang(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|exists:barangs,id',
            'kelas_peminjam' => 'required|string',
            'alasan_peminjam' => 'required|string',
            'tanggal_peminjaman' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status != 'peminjaman ditolak') {
            return response()->json(['message' => 'Peminjaman ulang hanya bisa dilakukan jika peminjaman sebelumnya ditolak.'], 400);
        }

        $peminjaman->update([
            'barang_id' => $request->barang_id,
            'kelas_peminjam' => $request->kelas_peminjam,
            'alasan_peminjam' => $request->alasan_peminjam,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'status' => 'waiting peminjaman',
            'alasan_penolakan' => null,
        ]);

        return response()->json(['message' => 'Peminjaman ulang berhasil diajukan.', 'data' => $peminjaman]);
    }

    // Method for pengembalian ulang (re-return)
    public function pengembalianUlang(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kondisi_barang' => 'required|string',
            'tanggal_dikembalikan' => 'required|date',
            'image_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status != 'pengembalian ditolak') {
            return response()->json(['message' => 'Pengembalian ulang hanya bisa dilakukan jika pengembalian sebelumnya ditolak.'], 400);
        }

        $pengembalianData = [
            'peminjaman_id' => $peminjaman->id,
            'kondisi_barang' => $request->kondisi_barang,
            'tanggal_dikembalikan' => $request->tanggal_dikembalikan,
        ];

        if ($request->hasFile('image_bukti')) {
            $imagePath = $request->file('image_bukti')->store('bukti_pengembalian', 'public');
            $pengembalianData['image_bukti'] = $imagePath;
        }

        $existingPengembalian = Pengembalian::where('peminjaman_id', $peminjaman->id)->first();

        if ($existingPengembalian) {
            $existingPengembalian->update($pengembalianData);
        } else {
            Pengembalian::create($pengembalianData);
        }

        $peminjaman->status = 'waiting pengembalian';
        $peminjaman->alasan_penolakan = null;
        $peminjaman->save();

        return response()->json(['message' => 'Pengembalian ulang berhasil diajukan.']);
    }

    public function rejectedPeminjaman()
    {
        $peminjamen = Peminjaman::where('status', 'ditolak')
            ->whereNotNull('alasan_penolakan')
            ->with('user', 'barang')
            ->get();

        return response()->json($peminjamen);
    }

    public function userRejectedPeminjamanDetail($id)
    {
        $user = Auth::user();

        $peminjaman = Peminjaman::where('status', 'ditolak')
            ->where('user_id', $user->id)
            ->where('id', $id)
            ->whereNotNull('alasan_penolakan')
            ->with('barang')
            ->firstOrFail();

        return response()->json($peminjaman);
    }
}
