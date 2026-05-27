<?php
 
// ============================================================
// FILE: app/Http/Controllers/MenuController.php
// ============================================================
 
namespace App\Http\Controllers;
 
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
 
class MenuController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->withCount('activeMenus')->get();
 
        $menus = Menu::with('category')
            ->where('is_available', true)
            ->when($request->category, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();
 
        $selectedCategory = $request->category;
 
        return view('menu.index', compact('menus', 'categories', 'selectedCategory'));
    }
 
    public function show(Menu $menu)
    {
        if (!$menu->is_available) {
            abort(404, 'Menu tidak tersedia');
        }
 
        $relatedMenus = Menu::where('category_id', $menu->category_id)
            ->where('id', '!=', $menu->id)
            ->where('is_available', true)
            ->take(4)
            ->get();
 
        return view('menu.show', compact('menu', 'relatedMenus'));
    }
}