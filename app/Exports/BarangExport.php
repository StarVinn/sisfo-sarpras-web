<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarangExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Barang::with('category')->get()->map(function ($barang) {
            return [
                $barang->id,
                $barang->nama,
                $barang->quantity,
                $barang->kondisi,
                $barang->category ? $barang->category->name : null,
                $barang->image,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Quantity',
            'Kondisi',
            'Category',
            'Image',
        ];
    }
}
