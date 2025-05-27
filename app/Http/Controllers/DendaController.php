<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    public function index()
    {
        $dendas = Denda::latest()->get();
        return view('admin.denda', compact('dendas'));
    }

    public function create()
    {
        return view('admin.create_denda');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'nominal' => 'required|numeric|min:0',
        ]);

        Denda::create($validated);

        return redirect()->route('admin.denda.index')->with('success', 'Denda berhasil ditambahkan.');
    }

    public function edit(Denda $denda)
    {
        return view('admin.edit_denda', compact('denda'));
    }

    public function update(Request $request, Denda $denda)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'nominal' => 'required|numeric|min:0',
        ]);

        $denda->update($validated);

        return redirect()->route('admin.denda.index')->with('success', 'Denda berhasil diperbarui.');
    }

    public function destroy(Denda $denda)
    {
        $denda->delete();

        return redirect()->route('admin.denda.index')->with('success', 'Denda berhasil dihapus.');
    }
}
