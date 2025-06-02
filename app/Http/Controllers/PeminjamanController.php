<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use App\Exports\PeminjamanExport;
use App\Models\Denda;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    // Method untuk menampilkan daftar peminjaman (khusus admin)
    public function index()
    {
        $peminjamen = Peminjaman::with('user', 'barang', 'pengembalian')->get(); // Eager load relasi including pengembalian
        return view('admin.peminjaman', compact('peminjamen')); // Menggunakan view admin.peminjaman
    }
    public function create(){
        $barangs = Barang::all(); // Ambil semua data barang
        return view('user.create_peminjaman', compact('barangs')); // Menggunakan view user.create_peminjaman
    }

    // Method untuk menampilkan daftar peminjaman user yang sedang login
    public function riwayatPeminjaman()
    {
        $user = Auth::user();
        $peminjamen = Peminjaman::where('user_id', $user->id)->with('barang', 'pengembalian')->get();
        return view('user.peminjaman', compact('peminjamen'));  // Menggunakan view user.peminjaman
    }


    // Method untuk membuat peminjaman baru (user)
     public function pinjamBarang(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'barang_id' => 'required|exists:barangs,id',
             'kelas_peminjam' => 'required|string',
             'alasan_peminjam' => 'required|string',
             'tanggal_peminjaman' => 'required|date',
         ]);

         if ($validator->fails()) {
             return redirect()->back()->withErrors($validator)->withInput();
         }

         $user = Auth::user();

         $peminjaman = Peminjaman::create([
             'user_id' => $user->id,
             'barang_id' => $request->barang_id,
             'kelas_peminjam' => $request->kelas_peminjam,
             'alasan_peminjam' => $request->alasan_peminjam,
             'tanggal_peminjaman' => $request->tanggal_peminjaman,
             'status' => 'waiting peminjaman', // Status default saat user meminjam
         ]);

         return redirect()->route('user.peminjaman.riwayat')->with('success', 'Peminjaman berhasil diajukan, menunggu konfirmasi admin.');
     }

    // Method untuk mengkonfirmasi peminjaman oleh admin
    public function konfirmasiPinjam($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = 'Dipinjam';
        $peminjaman->save();

        // Kurangi quantity barang saat peminjaman dikonfirmasi
        $barang = Barang::find($peminjaman->barang_id);
        if ($barang && $barang->quantity > 0) {
            $barang->quantity -= 1;
            $barang->save();
        }

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil dikonfirmasi.');
    }

     // Method untuk menampilkan form pengembalian (user)
     public function formPengembalian($id)
     {
         $peminjaman = Peminjaman::findOrFail($id);
          if (!in_array($peminjaman->status , ['Dipinjam','pengembalian ditolak'])) {
             return redirect()->back()->with('error', 'Barang ini belum bisa dikembalikan.');
         }
         return view('user.pengembalian', compact('peminjaman')); // Menggunakan view user.pengembalian
     }

    // Method untuk menyimpan data pengembalian (user)
    public function kembalikanBarang(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kondisi_barang' => 'required|string',
            'tanggal_dikembalikan' => 'required|date',
            'image_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
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

        $peminjaman->status = 'waiting pengembalian'; // Ubah status peminjaman menjadi waiting pengembalian
        $peminjaman->save();

        return redirect()->route('user.peminjaman.riwayat')->with('success', 'Pengembalian berhasil diajukan, menunggu konfirmasi admin.');
    }
    // form tolak 
    public function formTolak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        if (!in_array($peminjaman->status, ['waiting peminjaman', 'waiting pengembalian'])) {
            return redirect()->back()->with('error', 'Peminjaman tidak dapat ditolak.');
        }
        if ($peminjaman->status === 'waiting pengembalian') {
            return view('admin.tolak_pengembalian', compact('peminjaman'));
        } else { // waiting peminjaman
            return view('admin.tolak_peminjaman', compact('peminjaman'));
        }
    }

    // tolak peminjaman
    public function tolakPinjam(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        if (!in_array($peminjaman->status, ['waiting peminjaman'])) {
            return redirect()->back()->with('error', 'Peminjaman tidak dapat ditolak.');
        }

        $peminjaman->status = 'peminjaman ditolak';
        $peminjaman->alasan_penolakan = $request->alasan_penolakan;
        $peminjaman->save();

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil ditolak.');
    }
    // tolak pengembalian
    public function tolakKembali(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        if (!in_array($peminjaman->status, ['waiting pengembalian'])) {
            return redirect()->back()->with('error', 'Peminjaman tidak dapat ditolak.');
        }

        $peminjaman->status = 'pengembalian ditolak';
        $peminjaman->alasan_penolakan = $request->alasan_penolakan;
        $peminjaman->save();

        return redirect()->route('admin.peminjaman.index')->with('success', 'Pengembalian berhasil ditolak.');
    }

    // Method untuk mengkonfirmasi pengembalian oleh admin
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

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil dikonfirmasi.');
    }

    // Method untuk menampilkan detail pengembalian (admin)
     public function detailPengembalian($id)
     {
         $pengembalian = Pengembalian::where('peminjaman_id',$id)->with('peminjaman.user', 'peminjaman.barang')->firstOrFail(); // Eager load relasi
         return view('admin.pengembalian', compact('pengembalian')); // Menggunakan view admin.pengembalian
     }
     // Method untuk menampilkan detail pengembalian user
     public function detailPengembalianUser($id)
     {
         $user = Auth::user();
         $pengembalian = Pengembalian::where('peminjaman_id',$id)->with('peminjaman.user', 'peminjaman.barang')->firstOrFail(); // Eager load relasi
         return view('user.detail_pengembalian', compact('pengembalian')); // Menggunakan view user.detail_pengembalian
     }
     // detail peminjaman/pengembalian ditolak
     public function rejectedPeminjaman($id)
     {
         $peminjamen = Peminjaman::whereIn('status', ['peminjaman ditolak', 'pengembalian ditolak'])
        ->where('id', $id)    
         ->whereNotNull('alasan_penolakan')
             ->with('user', 'barang')
             ->get();

         return view('admin.detail_penolakan', compact('peminjamen'));
     }

     // detail peminjaman/pengembalian ditolak (user)
    public function userRejectedPeminjamanDetail($id)
    {
        $user = Auth::user();
        $peminjaman = Peminjaman::whereIn('status', ['peminjaman ditolak', 'pengembalian ditolak'])
            ->where('user_id', $user->id)
            ->where('id', $id)
            ->whereNotNull('alasan_penolakan')
            ->with('barang')
            ->firstOrFail();

        return view('user.detail_penolakan', compact('peminjaman'));
    }
    // form denda
    public function formDenda($pengembalianId){
        $dendas = Denda::all();
        $pengembalian = Pengembalian::findOrFail($pengembalianId);
        return view('admin.apply_denda', compact('dendas', 'pengembalian'));
    }
    // method apply denda
    public function applyDenda(Request $request, $pengembalianId)
    {
        $request->validate([
            'denda_id' => 'required|exists:dendas,id',
        ]);

        $pengembalian = Pengembalian::findOrFail($pengembalianId);

        $pengembalian->denda_id = $request->denda_id;
        $pengembalian->save();

        return redirect()->route('admin.peminjaman.index')->with('success', 'Denda berhasil diterapkan pada pengembalian.');
    }
    // method hapus denda jika sudah dibayar
    public function removeDenda($pengembalianId)
    {
        $pengembalian = Pengembalian::findOrFail($pengembalianId);

        if ($pengembalian->denda_id === null) {
            return redirect()->back()->with('info', 'Tidak ada denda yang diterapkan pada pengembalian ini.');
        }

        $pengembalian->denda_id = null;
        $pengembalian->save();

        return redirect()->route('admin.peminjaman.index')->with('success', 'Denda berhasil dihapus dari pengembalian.');
    }
    //export data peminjaman
    public function export(){
        return Excel::download(new PeminjamanExport, 'peminjaman.xlsx');
     }
}
