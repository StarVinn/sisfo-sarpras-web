<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = 
        [
            [
                'name' => 'Alat Tulis',
            ],
            [
                'name' => 'Elektronik',
            ],
            [
                'name' => 'Hardware',
            ],
            [
                'name' => 'Perabotan',
            ],
            [
                'name' => 'Olahraga',
            ],
        ];
        foreach ($kategori as $data) {
            Category::updateOrCreate(
                ['name' => $data['name']], // Cek apakah kategori sudah ada
                [
                    'name' => $data['name'],
                ]
            );
        }
    }
}
