<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('courses')->latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $this->authorize('manage-categories'); // Spatie
    
        $request->validate(['name' => 'required|string|max:255|unique:categories']);
        Category::create(['name' => $request->name]);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorize('manage-categories'); // Spatie

        $request->validate(['name' => 'required|string|max:255|unique:categories,name,' . $category->id]);
        $category->update(['name' => $request->name]);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diupdate.');
    }

    public function destroy(Category $category)
    {
        $this->authorize('manage-categories'); // Spatie

        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
