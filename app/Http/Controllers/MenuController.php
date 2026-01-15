<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::with('category')->latest();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('dish', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $menu = $query->get();
        $category = Category::all();

        return view('menus', compact('menu', 'category'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dish' => 'required|string|max:100',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        Menu::create($validated);
        return redirect()->back()->with('success', 'Menu added successfully!');
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'dish' => 'required|string|max:100',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($menu->photo && Storage::disk('public')->exists($menu->photo)) {
                Storage::disk('public')->delete($menu->photo);
            }
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $menu->update($validated);
        return redirect()->back()->with('success', 'Menu updated successfully!');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->back()->with('success', 'Menu moved to trash successfully!');
    }

    public function exportPdf(Request $request)
    {
        $query = Menu::with('category')->latest();

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('dish', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $menu = $query->get();
        $category = Category::all();

        $pdf = Pdf::loadView('pdf.menus', compact('menu', 'category'));
        $filename = 'menus_' . date('Y-m-d_His') . '.pdf';
        
        return $pdf->download($filename);
    }
}
