@extends('layouts.user')

@section('title', 'Riwayat Peminjaman')
@section('page_title', 'Riwayat Peminjaman Saya')

@section('content')
    {{-- <a href="{{ route('user.peminjaman.pinjam') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Pinjam Barang</a> --}}
    <div class="overflow-x-auto">
        <table class="min-w-full leading-normal shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">
                        ID
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
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $peminjaman->barang->nama }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $peminjaman->kelas_peminjam }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $peminjaman->tanggal_peminjaman }}</td>
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
                            @if ($peminjaman->status == 'Dipinjam')
                                <a href="{{ route('user.pengembalian.form', $peminjaman->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Kembalikan Barang</a>
                            @elseif ($peminjaman->status == 'Dikembalikan')
                                <a href="{{ route('user.pengembalian.detail', $peminjaman->id ) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Detail Kembali</a>
                            @elseif ($peminjaman->status == 'peminjaman ditolak')
                                <a href="{{ route('user.peminjaman.ditolak' , ['id' => $peminjaman->id]) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Detail Penolakan</a>
                            @elseif ($peminjaman->status == 'pengembalian ditolak')
                                <a href="{{ route('user.peminjaman.ditolak' , ['id' => $peminjaman->id]) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Detail Penolakan</a>
                                <a href="{{ route('user.pengembalian.form', $peminjaman->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Kembalikan Barang</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection