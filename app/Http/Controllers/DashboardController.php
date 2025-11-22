<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Menu;

class DashboardController extends Controller
{
    public function index()
    {
        $menu = Menu::all();
        $category = Category::all();

        return view('dashboard', compact('menu', 'category'));
    }
}
