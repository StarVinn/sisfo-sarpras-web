@extends('layouts.app')

@section('title', 'Daftar Peminjaman')
@section('page_title', 'Daftar Peminjaman')

@section('content')
<h4 class="text-lg font-bold">Welcome.. {{ Auth::user()->name }}</h4>
<h1 class="text-3xl font-bold mb-4">Daftar Peminjaman</h1>
<br>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <div class="overflow-x-auto">
        <table class="min-w-full leading-normal shadow-md rounded-lg overflow-x-auto">
            <thead class="bg-white text-black">
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">
                        ID
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">
                        Nama Peminjam
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">
                        Barang yang Dipinjam
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">
                        Kelas Peminjam
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">
                        Tanggal Peminjaman
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">
                        Alasan Peminjaman
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach ($peminjamen as $peminjaman)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $loop->iteration }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $peminjaman->user->name }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $peminjaman->barang->nama ?? "Barang tidak ada" }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $peminjaman->kelas_peminjam }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $peminjaman->tanggal_peminjaman }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $peminjaman->alasan_peminjam }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                            @if ($peminjaman->status == 'peminjaman ditolak' || $peminjaman->status == 'pengembalian ditolak')
                                <span class="relative inline-block px-3 py-1 font-semibold text-red-600 leading-tight">
                                    <span aria-hidden="true" class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                    <span class="relative">{{ $peminjaman->status }}</span>
                                </span>
                            @elseif ($peminjaman->status == 'waiting peminjaman' || $peminjaman->status == 'waiting pengembalian')
                                <span class="relative inline-block px-3 py-1 font-semibold text-yellow-600 leading-tight">
                                    <span aria-hidden="true" class="absolute inset-0 bg-yellow-200 opacity-50 rounded-full"></span>
                                    <span class="relative">{{ $peminjaman->status }}</span>
                                </span>
                            @elseif ($peminjaman->status == 'Dikembalikan' || $peminjaman->status == 'Dipinjam')
                                <span class="relative inline-block px-3 py-1 font-semibold text-green-600 leading-tight">
                                    <span aria-hidden="true" class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                    <span class="relative">{{ $peminjaman->status }}</span>
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                            <div class="flex space-x-2">
                                @if ($peminjaman->status == 'waiting peminjaman')
                                    <form action="{{ route('admin.peminjaman.konfirmasi-pinjam', $peminjaman->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Konfirmasi Peminjaman</button>
                                    </form>
                                    <a href="{{ route('admin.peminjaman.form-tolak', $peminjaman->id) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Tolak Peminjaman</a>
                                @elseif ($peminjaman->status == 'waiting pengembalian')
                                    <form action="{{ route('admin.peminjaman.konfirmasi-kembali', $peminjaman->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="bg-blue-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Konfirmasi Pengembalian</button>
                                    </form>
                                    <a href="{{ route('admin.peminjaman.form-tolak', $peminjaman->id) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Tolak Pengembalian</a>
                                    @elseif ($peminjaman->status == 'Dikembalikan')
                                        <a href="{{ route('admin.pengembalian.detail', $peminjaman->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded">Detail Pengembalian</a>
                                @elseif ($peminjaman->status == 'peminjaman ditolak')
                                    <a href="{{ route('admin.peminjaman.ditolak', $peminjaman->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded">Detail Penolakan</a>
                                @elseif ($peminjaman->status == 'pengembalian ditolak')
                                    <a href="{{ route('admin.peminjaman.ditolak', $peminjaman->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded">Detail Penolakan</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
