<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::latest();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $category = $query->get();
        $menu = Menu::all();

        return view('categories', compact('category', 'menu'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        Category::create($validated);
        return redirect()->back()->with('success', 'Category added successfully!');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($category->photo && Storage::disk('public')->exists($category->photo)) {
                Storage::disk('public')->delete($category->photo);
            }
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $category->update($validated);
        return redirect()->back()->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Category moved to trash successfully!');
    }

    public function exportPdf(Request $request)
    {
        $query = Category::latest();

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $category = $query->get();

        $pdf = Pdf::loadView('pdf.categories', compact('category'));
        $filename = 'categories_' . date('Y-m-d_His') . '.pdf';
        
        return $pdf->download($filename);
    }
}
