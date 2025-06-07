<?php

namespace Database\Seeders;

use App\Models\Denda;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dendas =
        [
            [
                'nama' => 'Pecah',
                'description' => 'Lensa, Badan, dll',
                'nominal' => 100000,
            ],
            [
                'nama' => 'Hilang',
                'description' => 'Tidak Dikembalikan 30 hari/lebih',
                'nominal' => 1500000,
            ],
            [
                'nama' => 'Terlambat',
                'description' => 'Tidak Dikembalikan 1 hari/lebih',
                'nominal' => 50000,
            ],
            [
                'nama' => 'Kelalaian',
                'description' => 'Lupa Mengembalikan, Tidak Mencatat Peminjaman',
                'nominal' => 10000,
            ],
        ];
        foreach ($dendas as $denda) {
            Denda::updateOrCreate(
                ['name' => $denda['nama']],
                [
                    'name' => $denda['nama'],
                    'description' => $denda['description'],
                    'nominal' => $denda['nominal'],
                ]
                );
        }
    }
}
