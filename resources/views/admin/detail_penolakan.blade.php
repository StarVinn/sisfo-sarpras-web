@extends('layouts.app')

@section('content')
<div class="container">
    <strong><h1>Detail Peminjaman/Pengembalian Ditolak</h1></strong>
    @if($peminjamen->isEmpty())
        <p>Tidak ada peminjaman yang ditolak.</p>
    @else
        @php
            $peminjaman = $peminjamen->first();
        @endphp
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nama Peminjam: {{ $peminjaman->user->name ?? 'N/A' }}</h5>
                <p class="card-text"><strong>Barang:</strong> {{ $peminjaman->barang->nama ?? 'N/A' }}</p>
                <p class="card-text"><strong>Kelas Peminjam:</strong> {{ $peminjaman->kelas_peminjam }}</p>
                <p class="card-text"><strong>Alasan Peminjam:</strong> {{ $peminjaman->alasan_peminjam }}</p>
                <p class="card-text"><strong>Alasan Penolakan:</strong> {{ $peminjaman->alasan_penolakan }}</p>
                <p class="card-text"><strong>Tanggal Peminjaman:</strong> {{ $peminjaman->tanggal_peminjaman }}</p>
                <p class="card-text"><strong>Status:</strong> {{ $peminjaman->status }}</p>
                <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-primary">Kembali ke Daftar</a>
            </div>
        </div>
    @endif
</div>
@endsection
