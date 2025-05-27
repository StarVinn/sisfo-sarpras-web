<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::where('role', '!=', 'admin')->get()->map(function ($user) {
            return [
                $user->id,
                $user->name,
                $user->email,
                $user->password,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Password',
        ];
    }
}
