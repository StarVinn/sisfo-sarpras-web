@extends('layouts.app')

@section('title', 'Detail Pengembalian')
@section('page_title', 'Detail Pengembalian Barang')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        <h5 class="text-3xl font-bold mb-4">Detail Pengembalian</h5>
        <p class="mb-2"><span class="font-semibold">Peminjam:</span> {{ $pengembalian->peminjaman->user->name }}</p>
        <p class="mb-2"><span class="font-semibold">Barang:</span> {{ $pengembalian->peminjaman->barang->nama ?? "Barang Tidak Ada"}}</p>
        <p class="mb-2"><span class="font-semibold">Tanggal Peminjaman:</span> {{ $pengembalian->peminjaman->tanggal_peminjaman }}</p>
        <p class="mb-2"><span class="font-semibold">Kondisi Barang:</span> {{ $pengembalian->kondisi_barang }}</p>
        <p class="mb-2"><span class="font-semibold">Tanggal Dikembalikan:</span> {{ $pengembalian->tanggal_dikembalikan }}</p>
        {{-- divider --}}
        @if ($pengembalian->denda_id == !null)
        <br>
        <h5 class="text-2xl font-bold mb-4 text-red-500">Detail Denda</h5>

        <p class="mb-2"><span class="font-semibold text-red-500">Nama Denda:</span> {{ $pengembalian->denda->name }}</p>
        <p class="mb-2"><span class="font-semibold text-red-500">Deskripsi:</span> {{ $pengembalian->denda->description }}</p>
        @php
            $totalDenda = 0;
        @endphp
        @if ($pengembalian->denda->name == 'terlambat')
            
            <p class="mb-2"><span class="font-semibold text-red-500">Jumlah Denda:</span> Rp.{{ number_format($pengembalian->denda->nominal, 0, ',', '.') }}</p>
            @php
            $totalDenda += $pengembalian->denda->nominal
            @endphp
            
            <p class="mt-4 font-bold text-blue-600">
                Total Semua Denda Terlambat: Rp.{{ number_format($totalDenda, 0, ',', '.') }}
            </p>
        @endif
        <p class="mb-2"><span class="font-semibold text-red-500">Jumlah Denda:</span> Rp.{{ number_format($pengembalian->denda->nominal, 0, ',', '.') }}</p>
            
        @endif
        
        @if ($pengembalian->image_bukti)
            <div class="mt-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Bukti Pengembalian:</label><br>
                <img src="{{ asset('storage/' . $pengembalian->image_bukti) }}" alt="Bukti Pengembalian" style="max-width: 300px;" class="rounded">
            </div>
        @endif
    </div>
    <div class="mt-4">
        <a href="{{ route('admin.peminjaman.index') }}" class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Kembali
        </a>
        <div class="inline-flex space-x-4 items-center">
            @if ($pengembalian->denda_id == null)
                 <a href="{{ route('admin.pengembalian.form-denda', $pengembalian->id) }}" class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Berikan Denda
            </a>
            @endif
           
            @if ($pengembalian->denda_id)
                <form action="{{ route('admin.pengembalian.removeDenda', $pengembalian->id) }}" method="POST" onsubmit="return confirm('Apakah denda yang dimiliki sudah dibayar?');" >
                    @csrf
                    <button type="submit" class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Hapus Denda</button>
                </form>
            @endif
        </div>
    </div>
@endsection
