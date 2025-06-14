@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-4">Form Apply Denda</h1>

<form action="{{ route('admin.pengembalian.applyDenda', $pengembalian->id) }}" method="POST">
    @csrf
    <div class="mb-4">
        <label for="denda_id" class="block text-gray-700 font-bold mb-2">Pilih Denda:</label>
        <select name="denda_id" id="denda_id" required
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @foreach ($dendas as $denda)
                <option value="{{ $denda->id }}">{{ $denda->name }} (Rp{{ number_format($denda->nominal, 0, ',', '.') }})</option>
            @endforeach
        </select>
        @error('denda_id')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Apply Denda</button>
    <a href="{{ route('admin.peminjaman.index') }}" class="ml-4 text-gray-700 hover:text-gray-900">Batal</a>
</form>

@endsection
