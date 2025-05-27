@extends('layouts.user')

@section('title', 'Form Peminjaman')
@section('page_title', 'Form Peminjaman Barang')

@section('content')
    <div class="max-w-md mx-auto bg-white shadow-md rounded-md p-6">
        <h1 class="text-3xl font-bold mb-6 text-sky-600 text-center">Form Peminjaman</h1>
        <form action="{{ route('user.peminjaman.pinjam.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label for="barang_id" class="block text-sm font-medium text-sky-500 mb-1">Pilih Barang</label>
                <select id="barang_id" name="barang_id" required
                    class="w-full border border-sky-500 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id }}">{{ $barang->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="kelas_peminjam" class="block text-sm font-medium text-sky-500 mb-1">Kelas Peminjam</label>
                <input type="text" id="kelas_peminjam" name="kelas_peminjam" required
                    class="w-full border border-sky-500 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent" />
            </div>
            <div>
                <label for="alasan_peminjam" class="block text-sm font-medium text-sky-500 mb-1">Alasan Peminjam</label>
                <input type="text" id="alasan_peminjam" name="alasan_peminjam" required
                    class="w-full border border-sky-500 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent" />
            </div>
            <div>
                <label for="tanggal_peminjaman" class="block text-sm font-medium text-sky-500 mb-1">Tanggal Peminjaman</label>
                <input type="date" id="tanggal_peminjaman" name="tanggal_peminjaman" required
                    class="w-full border border-sky-500 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent" />
            </div>
            <button type="submit"
                class="w-full bg-sky-500 text-white font-semibold py-2 rounded-md hover:bg-sky-900 transition-colors duration-300">
                Ajukan Peminjaman
            </button>
            <a href="{{ url()->previous() }}" 
                class="block text-center mt-4 text-sky-500 hover:text-sky-700 font-semibold">
                &larr; Kembali
            </a>
        </form>
    </div>
@endsection
