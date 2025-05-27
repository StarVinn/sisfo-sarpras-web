@extends('layouts.user')

@section('content')

<h4 class="text-lg font-bold">Welcome.. {{ Auth::user()->name }}</h4>
<h1 class="text-3xl font-bold mb-4">Daftar Barang</h1>
<br>

{{-- Dropdown Category Filter ---}} 
{{-- <label class="block text-gray-700 text-sm font-bold mb-2">Filter Kategori:</label>
<select id="categorySelect" onchange="loadBarang()" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline mb-4">
    <option value="">Semua Kategori</option>
    @foreach(App\Models\Category::all() as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
    @endforeach
</select> --}}

{{-- Dropdown Sort ---}} 
{{-- <label class="block text-gray-700 text-sm font-bold mb-2">Urutkan Nama:</label>
<select id="sortSelect" onchange="loadBarang()" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline mb-4">
    <option value="az">A-Z</option>
    <option value="za">Z-A</option>
</select> --}}
<br><br>
<table class="table-auto w-full">
    <thead>
        <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Foto</th>
            <th class="px-4 py-2">Nama</th>
            <th class="px-4 py-2">Quantity</th>
            <th class="px-4 py-2">Kondisi</th>
            <th class="px-4 py-2">Kategory</th>
            <th class="px-4 py-2">Aksi</th>

        </tr>
    </thead>
    <tbody id="barang-table-body">
        @foreach ($barangs as $barang)
            <tr>
                <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                <td class="border px-4 py-2"><img src="{{ asset('storage/barang_images/' . $barang->image) }}" alt="{{ $barang->nama }}" class="w-16 h-16 object-cover"></td>
                <td class="border px-4 py-2">{{ $barang->nama }}</td>
                <td class="border px-4 py-2">{{ $barang->quantity }}</td>
                <td class="border px-4 py-2">{{ $barang->kondisi }}</td>
                <td class="border px-4 py-2">{{ $barang->category->name }}</td>
                @if ($barang->quantity > 0)
                    <td class="border px-4 py-2">
                    <a href="{{ route('user.peminjaman.pinjam') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Pinjam</a>
                </td>
                @endif
                
                @endforeach
            </tr>
    </tbody>
</table>
@endsection

@section('scripts')
<script>
    // Function to update barang quantity dynamically
    // Currently reloads the page to reflect updated quantities
    // Can be enhanced with AJAX to update quantities without full reload
    function updateBarangQuantity() {
        location.reload();
    }
</script>
@endsection
