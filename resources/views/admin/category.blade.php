@extends('layouts.app')

@section('content')

<h4 class="text-lg font-bold">Welcome.. {{ Auth::user()->name }}</h4>
<h1 class="text-3xl font-bold mb-4">Daftar Kategori</h1>

<a href="{{ route('admin.category.create') }}" class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded">Tambah Kategori</a>
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
        </tr>
    </thead>
    <tbody id="category-table-body">
        @foreach ($categories as $category)
            <tr>
                <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                <td class="border px-4 py-2">{{ $category->name }}</td>
                @endforeach
            </tr>
    </tbody>
</table>
@endsection
