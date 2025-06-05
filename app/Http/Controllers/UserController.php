<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;


class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->get();

        return view('admin.users', compact('users'));
    }

    // Hapus user berdasarkan ID
    public function destroy($id)
    {
        $user = User::where('role', 'user')->findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Akun berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download(new UserExport, 'user.xlsx');
    }
}
