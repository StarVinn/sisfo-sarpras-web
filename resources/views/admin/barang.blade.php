@extends('layouts.app')

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
<a href="{{ route('admin.barang.create') }}" class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded">Tambah Barang</a>
<br><br>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <table id="barangTable" class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Quantity</th>
                <th>Kondisi</th>
                <th>Kategori</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let dataTable = $('#barangTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '/api/barangs',
                    type: 'GET',
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'nama', name: 'nama' },
                    { data: 'quantity', name: 'quantity' },
                    { data: 'kondisi', name: 'kondisi' },
                    { data: 'category_name', name: 'category_name' },
                    {
                        data: 'image',
                        name: 'image',
                        render: function(data) {
                            return data ? `<img src="{{ asset('storage/${data}') }}" alt="Gambar Barang" width="50">` : '-';
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `
                                <a href="/admin/barang/${data.id}/edit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-2 rounded">Edit</a>
                                <br>
                                <form action="/admin/barang/${data.id}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded">Hapus</button>
                                </form>
                            `;
                        },
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            function loadCategories() {
                $.ajax({
                    url: '/api/categories',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            let options = '<option value="">Pilih Kategori</option>';
                            response.data.forEach(category => {
                                options += `<option value="${category.id}">${category.nama}</option>`;
                            });
                            $('#category_id_tambah').html(options);
                            $('#category_id_edit').html(options);
                        } else {
                            console.error('Gagal mengambil data kategori:', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }

            loadCategories();
        });
    </script>
@endsection