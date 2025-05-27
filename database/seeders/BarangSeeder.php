<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barang = 
        [
            [
                'nama' => 'Proyektor',
                'quantity' => 5,
                'kondisi' => 'Baik',
                'category_id' => 2,
                'image' => 'barang_images/ZzrjBP4TDfojKpHQa4yip5ugL5aLmX3ZgYgwwH4f.jpg',
            ],
            // [
            //     'nama' => 'Pensil',
            //     'quantity' => 10,
            //     'kondisi' => 'Baik',
            //     'category_id' => 1,
            //     'image' => 'ZzrjBP4TDfojKpHQa4yip5ugL5aLmX3ZgYgwwH4f.jpg',
            // ],
            
        ];
        foreach ($barang as $data) {
            Barang::updateOrCreate(
                ['nama' => $data['nama']], // Check if barang already exists by 'nama'
                [
                    'nama' => $data['nama'],
                    'quantity' => $data['quantity'],
                    'kondisi' => $data['kondisi'],
                    'category_id' => $data['category_id'],
                    'image' => $data['image'],
                ]
            );
        }
        
    }
}
