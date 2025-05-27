@extends('layouts.app')

@section('content')
<h4 class="text-lg font-bold">Welcome.. {{ Auth::user()->name }}</h4>
<h1 class="text-3xl font-bold mb-4">Daftar Denda</h1>

<a href="{{ route('admin.denda.form-create') }}" class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded">Tambah Denda</a>
<br><br>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<table class="table-auto w-full">
    <thead>
        <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Nama</th>
            <th class="px-4 py-2">Deskripsi</th>
            <th class="px-4 py-2">Nominal</th>
            <th class="px-4 py-2">Aksi</th>
        </tr>
    </thead>
    <tbody id="denda-table-body">
        @foreach ($dendas as $denda)
            <tr>
                <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                <td class="border px-4 py-2">{{ $denda->name }}</td>
                <td class="border px-4 py-2">{{ $denda->description }}</td>
                <td class="border px-4 py-2">Rp.{{ number_format($denda->nominal, 0, ',', '.') }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('admin.denda.form-edit', $denda->id ) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-2 rounded">Edit</a>
                                <br>
                                <form action="{{ route('admin.denda.delete', $denda->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded">Hapus</button>
                                </form>
                </td>
                @endforeach
            </tr>
    </tbody>
</table>
@endsection