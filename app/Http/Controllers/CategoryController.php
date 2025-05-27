<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Exports\KategoriExport;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.category', compact('categories'));
    }

    public function create()
    {
        return view('admin.create_category');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($validated);

        return redirect()->route('admin.category.index')->with('success', 'Category created successfully.');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($validated);

        return redirect()->route('admin.category.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        // Disconnect all related barangs by setting category_id to null
        $category->barangs()->update(['category_id' => null]);

        // Soft delete the category
        $category->delete();
        
        return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully.');
    }
    public function export()
    {
        return Excel::download(new KategoriExport, 'kategori.xlsx');
    }
}
