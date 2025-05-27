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
                'id' => 1,
                'nama' => 'Pecah',
                'description' => 'Lensa, Badan, dll',
                'nominal' => 100000,
            ]
        ];
        foreach ($dendas as $denda) {
            Denda::updateOrCreate(
                ['id' => $denda['id']],
                [
                    'name' => $denda['nama'],
                    'description' => $denda['description'],
                    'nominal' => $denda['nominal'],
                ]
                );
        }
    }
}
