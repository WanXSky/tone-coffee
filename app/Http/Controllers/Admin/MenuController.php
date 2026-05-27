<?php

// ============================================================
// FILE: app/Http/Controllers/Admin/MenuController.php
// ============================================================
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
 
class MenuController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::with('category')
            ->when($request->search, fn($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->when($request->category, fn($q, $c) => $q->where('category_id', $c))
            ->latest()
            ->paginate(15);
 
        $categories = Category::all();
 
        return view('admin.menu.index', compact('menus', 'categories'));
    }
 
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.menu.create', compact('categories'));
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'is_available'=> 'boolean',
            'stock'       => 'required|integer|min:0',
        ]);
 
        $data         = $request->except('image');
        $data['slug'] = Str::slug($request->name) . '-' . uniqid();
 
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menus', 'public');
        }
 
        Menu::create($data);
 
        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil ditambahkan!');
    }
 
    public function edit(Menu $menu)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.menu.edit', compact('menu', 'categories'));
    }
 
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string|max:100',
            'description'  => 'nullable|string|max:500',
            'price'        => 'required|numeric|min:0',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'is_available' => 'boolean',
            'stock'        => 'required|integer|min:0',
        ]);
 
        $data = $request->except('image');
 
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menus', 'public');
        }
 
        $menu->update($data);
 
        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil diperbarui!');
    }
 
    public function destroy(Menu $menu)
    {
        $menu->update(['is_available' => false]);
 
        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil dinonaktifkan.');
    }
 
    public function toggleAvailable(Menu $menu)
    {
        $menu->update(['is_available' => !$menu->is_available]);
 
        return response()->json([
            'success'      => true,
            'is_available' => $menu->is_available,
        ]);
    }
}
