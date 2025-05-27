<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PeminjamanExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Peminjaman::with(['user', 'barang'])
            ->where('status', 'dikembalikan')
            ->get()
            ->map(function ($peminjaman) {
                return [
                    $peminjaman->id,
                    $peminjaman->user ? $peminjaman->user->name : null,
                    $peminjaman->barang ? $peminjaman->barang->nama : null,
                    $peminjaman->kelas_peminjam,
                    $peminjaman->alasan_peminjam,
                    $peminjaman->tanggal_peminjaman,
                    $peminjaman->status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'User Name',
            'Barang Name',
            'Kelas Peminjam',
            'Alasan Peminjam',
            'Tanggal Peminjaman',
            'Status',
        ];
    }
}
