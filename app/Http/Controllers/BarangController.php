<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Exports\BarangExport;
use Maatwebsite\Excel\Facades\Excel;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('category')->get();
        return view('admin.barang', compact('barangs'));
    }
    public function indexuser(){
        $barangs = Barang::with('category')->get();
        return view('user.barang', compact('barangs'));
    }

    public function export(){
        return Excel::download(new BarangExport, 'barang.xlsx');
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.create_barang', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'kondisi' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('barang_images', 'public');
            $validated['image'] = $path;
        }

        Barang::create($validated);

        return redirect()->route('admin.barang.index')->with('success', 'Barang created successfully.');
    }

    public function show(Barang $barang)
    {
        return view('admin.barang_show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $categories = Category::all();
        return view('admin.edit_barang', compact('barang', 'categories'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'kondisi' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('barang_images', 'public');
            $validated['image'] = $path;
        }

        $barang->update($validated);

        return redirect()->route('admin.barang.index')->with('success', 'Barang updated successfully.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('admin.barang.index')->with('success', 'Barang deleted successfully.');
    }
}
