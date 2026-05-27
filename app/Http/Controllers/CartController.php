<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart  = session('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['subtotal']);

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'qty'     => 'required|integer|min:1|max:20',
            'notes'   => 'nullable|string|max:255',
        ]);

        $menu = Menu::findOrFail($request->menu_id);

        if (!$menu->is_available) {
            return response()->json([
                'success' => false,
                'message' => 'Menu tidak tersedia'
            ], 400);
        }

        $cart    = session('cart', []);
        $menuKey = $menu->id;

        if (isset($cart[$menuKey])) {
            $cart[$menuKey]['qty'] += $request->qty;
        } else {
            $cart[$menuKey] = [
                'menu_id' => $menu->id,
                'name'    => $menu->name,
                'price'   => $menu->price,
                'image'   => $menu->image_url,
                'qty'     => $request->qty,
                'notes'   => $request->notes,
            ];
        }

        // hitung ulang subtotal
        $cart[$menuKey]['subtotal'] = $cart[$menuKey]['price'] * $cart[$menuKey]['qty'];

        session(['cart' => $cart]);

        $cartCount = collect($cart)->sum('qty');
        $total     = collect($cart)->sum('subtotal');
        $grand     = $total + 5000;

        return response()->json([
            'success'    => true,
            'message'    => $menu->name . ' ditambahkan ke keranjang',
            'cart_count' => $cartCount,
            'total_fmt'  => 'Rp' . number_format($total, 0, ',', '.'),
            'grand_fmt'  => 'Rp' . number_format($grand, 0, ',', '.'),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'menu_id' => 'required',
            'qty'     => 'required|integer|min:1|max:20',
        ]);

        $cart    = session('cart', []);
        $menuKey = $request->menu_id;

        if (!isset($cart[$menuKey])) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan',
            ], 404);
        }

        // update qty
        $cart[$menuKey]['qty'] = $request->qty;

        // update subtotal item
        $cart[$menuKey]['subtotal'] =
            $cart[$menuKey]['price'] * $request->qty;

        session(['cart' => $cart]);

        $total     = collect($cart)->sum('subtotal');
        $cartCount = collect($cart)->sum('qty');
        $grand     = $total + 5000;

        return response()->json([
            'success' => true,

            // penting untuk update UI
            'cart_count' => $cartCount,

            // total sidebar
            'total_fmt' => 'Rp' . number_format($total, 0, ',', '.'),
            'grand_fmt' => 'Rp' . number_format($grand, 0, ',', '.'),

            // subtotal item yg berubah
            'item_subtotal_fmt' => 'Rp' . number_format($cart[$menuKey]['subtotal'], 0, ',', '.'),
        ]);
    }

    public function remove(Request $request)
    {
        $cart = session('cart', []);
        $menuKey = $request->menu_id;

        if (isset($cart[$menuKey])) {
            unset($cart[$menuKey]);
        }

        session(['cart' => $cart]);

        $cartCount = collect($cart)->sum('qty');
        $total     = collect($cart)->sum('subtotal');
        $grand     = $total + 5000;

        return response()->json([
            'success' => true,
            'cart_count' => $cartCount,
            'total_fmt'  => 'Rp' . number_format($total, 0, ',', '.'),
            'grand_fmt'  => 'Rp' . number_format($grand, 0, ',', '.'),
        ]);
    }

    public function clear()
    {
        session()->forget('cart');

        return redirect()
            ->route('cart')
            ->with('success', 'Keranjang dikosongkan');
    }
}