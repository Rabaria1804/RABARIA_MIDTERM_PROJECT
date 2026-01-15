<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class TrashController extends Controller
{
    public function index()
    {
        $deletedMenus = Menu::onlyTrashed()->with('category')->latest()->get();
        $deletedCategories = Category::onlyTrashed()->latest()->get();

        return view('trash', compact('deletedMenus', 'deletedCategories'));
    }

    public function restoreMenu($id)
    {
        $menu = Menu::onlyTrashed()->findOrFail($id);
        $menu->restore();
        
        return redirect()->back()->with('success', 'Menu restored successfully!');
    }

    public function restoreCategory($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        
        return redirect()->back()->with('success', 'Category restored successfully!');
    }

    public function forceDeleteMenu($id)
    {
        $menu = Menu::onlyTrashed()->findOrFail($id);
        
        // Delete photo if exists
        if ($menu->photo && Storage::disk('public')->exists($menu->photo)) {
            Storage::disk('public')->delete($menu->photo);
        }
        
        $menu->forceDelete();
        
        return redirect()->back()->with('success', 'Menu permanently deleted!');
    }

    public function forceDeleteCategory($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        
        // Delete photo if exists
        if ($category->photo && Storage::disk('public')->exists($category->photo)) {
            Storage::disk('public')->delete($category->photo);
        }
        
        $category->forceDelete();
        
        return redirect()->back()->with('success', 'Category permanently deleted!');
    }
}
