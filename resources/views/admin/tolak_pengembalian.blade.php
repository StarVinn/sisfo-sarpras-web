@extends('layouts.app')

@section('title', 'Form Penolakan Peminjaman')
@section('page_title', 'Form Penolakan Peminjaman')

@section('content')
<h1 class="text-3xl font-bold mb-4">Form Penolakan Pengembalian</h1>

<form action="{{ route('admin.peminjaman.tolak-kembali', $peminjaman->id) }}" method="POST">
    @csrf
    <div class="mb-4">
        <label for="alasan_penolakan" class="block text-gray-700 font-bold mb-2">Alasan Penolakan:</label>
        <textarea name="alasan_penolakan" id="alasan_penolakan" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('alasan_penolakan') }}</textarea>
        @error('alasan_penolakan')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Tolak Peminjaman</button>
    <a href="{{ route('admin.peminjaman.index') }}" class="ml-4 text-gray-700 hover:text-gray-900">Batal</a>
</form>
@endsection
