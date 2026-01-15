<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Menu;

class DashboardController extends Controller
{
    public function index()
    {
        // Get only non-deleted items
        $menu = Menu::latest()->take(5)->get();
        $category = Category::latest()->take(5)->get();
        
        // Get counts (excluding soft deleted)
        $totalMenus = Menu::count();
        $totalCategories = Category::count();
        $deletedMenus = Menu::onlyTrashed()->count();
        $deletedCategories = Category::onlyTrashed()->count();

        return view('dashboard', compact('menu', 'category', 'totalMenus', 'totalCategories', 'deletedMenus', 'deletedCategories'));
    }
}
