<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;

class MenuController extends Controller
{
    public function index()
    {
        $menu = Menu::latest()->get();
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
        ]);

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
        ]);

        $menu->update($validated);
        return redirect()->back()->with('success', 'Menu updated successfully!');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->back()->with('success', 'Menu deletd successfully!');
    }
}
