<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Menu;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::latest()->get();
        $menu = Menu::all();

        return view('categories', compact('category', 'menu'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
        ]);

        Category::create($validated);
        return redirect()->back()->with('success', 'Category added successfully!');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
        ]);

        $category->update($validated);
        return redirect()->back()->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully!');
    }
}
