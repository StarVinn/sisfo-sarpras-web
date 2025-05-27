@extends('layouts.user')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-center font-bold text-2xl mb-6">Detail Peminjaman Ditolak</h1>
    @if(!$peminjaman)
        <p class="text-center">Peminjaman tidak ditemukan.</p>
    @else
        <div class="bg-white shadow-md rounded p-4 mb-4 max-w-xl mx-auto">
            <h5 class="text-lg font-semibold mb-2">Nama Peminjam: {{ $peminjaman->user->name ?? 'N/A' }}</h5>
            <p class="mb-1"><strong>Kelas Peminjam:</strong> {{ $peminjaman->kelas_peminjam }}</p>
            <p class="mb-1"><strong>Alasan Peminjam:</strong> {{ $peminjaman->alasan_peminjam }}</p>
            <p class="mb-1"><strong>Alasan Penolakan:</strong> {{ $peminjaman->alasan_penolakan }}</p>
            <p class="mb-1"><strong>Tanggal Peminjaman: {{ $peminjaman->tanggal_peminjaman }}</strong></p>
            <p class="mb-1"><strong>Status: {{ $peminjaman->status }}</strong></p>
            <a href="{{ url()->previous() }}" 
                class="block text-center mt-4 text-sky-500 hover:text-sky-700 font-semibold">
                &larr; Kembali
            </a>
        </div>
    @endif
</div>
@endsection
