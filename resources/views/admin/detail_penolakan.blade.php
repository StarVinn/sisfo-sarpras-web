@extends('layouts.app')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
        @php
            // Find the peminjaman with the given id if $peminjamanId is passed to the view
            if (isset($peminjamanId)) {
                $peminjaman = $peminjamen->firstWhere('id', $peminjamanId);
            } else {
                $peminjaman = $peminjamen->first();
            }
        @endphp
        @if ($peminjaman->status == 'peminjaman ditolak')
            <h5 class="text-3xl font-bold mb-4">Detail Peminjaman</h5>
        @elseif ($peminjaman->status == 'pengembalian ditolak')
            <h5 class="text-3xl font-bold mb-4">Detail Pengembalian</h5>
        @endif
        <p class="mb-2"><span class="font-semibold">Nama Peminjam:</span> {{ $peminjaman->user->name }}</p>
        <p class="mb-2"><strong>Barang:</strong> {{ $peminjaman->barang->nama ?? 'N/A' }}</p>
        <p class="mb-2"><strong>Kelas Peminjam:</strong> {{ $peminjaman->kelas_peminjam }}</p>
        <p class="mb-2"><strong>Alasan Peminjam:</strong> {{ $peminjaman->alasan_peminjam }}</p>
        <p class="mb-2"><strong>Tanggal Peminjaman:</strong> {{ $peminjaman->tanggal_peminjaman }}</p>
        <p class="mb-2"><strong>Status:</strong> {{ $peminjaman->status }}</p>
        <p class="mb-2 text-red-500"><strong>Alasan Penolakan:</strong> {{ $peminjaman->alasan_penolakan }}</p>
        <br>
        <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-primary">Kembali ke Daftar</a>
</div>
@endsection
