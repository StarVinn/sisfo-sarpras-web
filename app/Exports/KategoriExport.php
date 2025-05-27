<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KategoriExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Category::all()->map(function ($category) {
            return [
                $category->id,
                $category->name,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
        ];
    }
}
