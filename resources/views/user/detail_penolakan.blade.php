@extends('layouts.user')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    @if ($peminjaman->status == 'peminjaman ditolak')
            <h5 class="text-3xl font-bold mb-4">Detail Peminjaman</h5>
        @elseif ($peminjaman->status == 'pengembalian ditolak')
            <h5 class="text-3xl font-bold mb-4">Detail Pengembalian</h5>
        @endif
        
    @if(!$peminjaman)
        <p class="text-center">Peminjaman tidak ditemukan.</p>
    @else   
    <br>
            <p class="mb-2"><strong>Nama Peminjam: </strong>{{ $peminjaman->user->name ?? 'N/A' }}</h5>
            <p class="mb-2"><strong>Kelas Peminjam:</strong> {{ $peminjaman->kelas_peminjam }}</p>
            <p class="mb-2"><strong>Alasan Peminjam:</strong> {{ $peminjaman->alasan_peminjam }}</p>
            <p class="mb-2"><strong>Alasan Penolakan:</strong> {{ $peminjaman->alasan_penolakan }}</p>
            <p class="mb-2"><strong>Tanggal Peminjaman: {{ $peminjaman->tanggal_peminjaman }}</strong></p>
            <p class="mb-2"><strong>Status: {{ $peminjaman->status }}</strong></p>
            <a href="{{ url()->previous() }}" 
                class="block text-center mt-4 text-sky-500 hover:text-sky-700 font-semibold">
                &larr; Kembali
            </a>
    @endif
</div>
@endsection
