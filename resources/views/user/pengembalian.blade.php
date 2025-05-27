@extends('layouts.user')

@section('title', 'Form Pengembalian Barang')
@section('page_title', 'Form Pengembalian Barang')

@section('content')
    <div class="max-w-md mx-auto bg-white shadow-md rounded-md p-6">
        <form action="{{ route('user.pengembalian.kembalikan', $peminjaman->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label for="kondisi_barang" class="block text-sm font-medium text-sky-500 mb-1">Kondisi Barang</label>
                <textarea id="kondisi_barang" name="kondisi_barang" required
                    class="w-full border border-sky-500 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent resize-none"></textarea>
            </div>
            <div>
                <label for="tanggal_dikembalikan" class="block text-sm font-medium text-sky-500 mb-1">Tanggal Dikembalikan</label>
                <input type="date" id="tanggal_dikembalikan" name="tanggal_dikembalikan" required
                    class="w-full border border-sky-500 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent" />
            </div>
            <div>
                <label for="image_bukti" class="block text-sm font-medium text-sky-500 mb-1">Bukti Pengembalian (Foto)</label>
                <input type="file" id="image_bukti" name="image_bukti" accept="image/*"
                    class="w-full border border-sky-500 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent" />
                <small class="text-muted">Format: jpeg, png, jpg, gif. Maksimal 2MB.</small>
            </div>
            <button type="submit"
                class="w-full bg-sky-500 text-white font-semibold py-2 rounded-md hover:bg-sky-900 transition-colors duration-300">
                Submit Pengembalian
            </button>
        </form>
    </div>
@endsection
