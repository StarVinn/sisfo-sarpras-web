<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class BarangController extends Controller
{
    use SoftDeletes;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangs = Barang::with('category')->get();

        $barangs = $barangs->map(function ($barang) {
            return [
                'id' => $barang->id,
                'nama' => $barang->nama,
                'quantity' => $barang->quantity,
                'kondisi' => $barang->kondisi,
                'category_id' => $barang->category_id,
                'category_name' => $barang->category ? $barang->category->name : null,
                'image' => $barang->image,
            ];
        });


        return response()->json([
            'success' => true,
            'message' => 'Daftar Barang',
            'data' => $barangs,
        ], 200)->header('Access-Control-Allow-Origin', '*');
    }
    public function indexmobile()
    {
        $barangs = Barang::with('category')->get();

        $barangs = $barangs->map(function ($barang) {
            return [
                'id' => $barang->id,
                'nama' => $barang->nama,
                'quantity' => $barang->quantity,
                'kondisi' => $barang->kondisi,
                'category_id' => $barang->category_id,
                'category_name' => $barang->category ? $barang->category->name : null,
                'image' => $barang->image ? asset('storage/' . $barang->image) : null,
            ];
        });


        return response()->json([
            'success' => true,
            'message' => 'Daftar Barang',
            'data' => $barangs,
        ], 200)->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'kondisi' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
        return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal!',
                'errors' => $validator->errors(),
            ], 422)->header('Access-Control-Allow-Origin', '*');
        }

        $validated = $validator->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('barang_images', 'public');
            $validated['image'] = $path;
        }

        $barang = Barang::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil ditambahkan!',
            'data' => $barang,
        ], 201)->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail Barang',
            'data' => $barang,
        ], 200)->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer|min:0',
            'kondisi' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
        return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal!',
                'errors' => $validator->errors(),
            ], 422)->header('Access-Control-Allow-Origin', '*');
        }

        $validated = $validator->validated();

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($barang->image) {
                Storage::delete('public/' . $barang->image);
            }

            $path = $request->file('image')->store('barang_images', 'public');
            $validated['image'] = $path;
        }

        $barang->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil diupdate!',
            'data' => $barang,
        ], 200)->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil dihapus!',
        ], 200)->header('Access-Control-Allow-Origin', '*');
    }
}