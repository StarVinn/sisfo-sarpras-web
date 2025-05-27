<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [ 
            [
                'name' => 'Vinn',
                'email' => 'test@gmail.com',
                'password' => '123',
                'role' => 'user',
            ],
            [
                'name' => 'Zikra',
                'email' => 'zikra@gmail.com',
                'password' => '123',
                'role' => 'user',
            ],
            // Anda bisa menambahkan data user lain di sini dalam format yang sama
        ];

        foreach ($users as $userData) { 
            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => $userData['password'],
                    'role' => $userData['role'],
                ]
            );
        }
    }
}