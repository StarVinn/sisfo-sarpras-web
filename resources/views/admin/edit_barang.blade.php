@extends('layouts.app')

@section('title', 'Edit Barang')
@section('page_title', 'Edit Barang')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <form action="{{ route('admin.barang.update', $barang) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nama" class="block text-gray-700 font-bold mb-2">Nama Barang</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $barang->nama) }}" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="quantity" class="block text-gray-700 font-bold mb-2">Quantity</label>
                <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $barang->quantity) }}" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('quantity')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="kondisi" class="block text-gray-700 font-bold mb-2">Kondisi</label>
                <input type="text" id="kondisi" name="kondisi" value="{{ old('kondisi', $barang->kondisi) }}" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('kondisi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 font-bold mb-2">Kategori</label>
                <select id="category_id" name="category_id" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $barang->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-bold mb-2">Gambar Barang</label>
                <input type="file" id="image" name="image" accept="image/*"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @if ($barang->image)
                    <img src="{{ asset('storage/' . $barang->image) }}" alt="Gambar Barang" class="mt-2 max-h-40">
                @endif
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Barang</button>
                <a href="{{ route('admin.barang.index') }}"
                    class="ml-4 inline-block bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Batal</a>
            </div>
        </form>
    </div>
@endsection
