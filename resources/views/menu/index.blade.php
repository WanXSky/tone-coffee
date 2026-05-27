{{-- ============================================================ --}}
{{-- FILE: resources/views/menu/index.blade.php                   --}}
{{-- ============================================================ --}}
@extends('layouts.app')
@section('title', 'Menu Minuman')
 
@section('content')
{{-- Hero section --}}
<section class="bg-gradient-to-br from-red-600 via-red-700 to-red-800 text-white py-14 px-4">
    <div class="max-w-7xl mx-auto text-center">
        <h1 class="text-4xl md:text-5xl font-black mb-3 animate__animated animate__fadeInDown">
            Menu <span class="text-yellow-300"> Twenty One</span> Coffee
        </h1>
        <p class="text-red-100 text-lg mb-8 animate__animated animate__fadeInUp">Pilih minuman favoritmu, kami antarkan ke rumahmu! 🚀</p>
 
        {{-- Search bar --}}
        <form action="{{ route('menu') }}" method="GET" class="max-w-lg mx-auto animate__animated animate__fadeInUp">
            @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <div class="flex gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari minuman favorit kamu..."
                    class="flex-1 px-5 py-3 rounded-full text-gray-900 font-medium focus:outline-none focus:ring-4 focus:ring-yellow-300 shadow-lg">
                <button type="submit" class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold px-6 py-3 rounded-full transition shadow-lg">
                    🔍
                </button>
            </div>
        </form>
    </div>
</section>
 
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Filter kategori --}}
    <div class="flex gap-2 mb-8 overflow-x-auto pb-2 scrollbar-hide">
        <a href="{{ route('menu') }}"
           class="flex-shrink-0 px-5 py-2.5 rounded-full font-semibold text-sm transition
                  {{ !request('category') ? 'bg-red-600 text-white shadow-md shadow-red-200' : 'bg-white text-gray-600 border border-gray-200 hover:border-red-400 hover:text-red-600' }}">
            Semua Menu
        </a>
        @foreach($categories as $category)
        <a href="{{ route('menu', ['category' => $category->id]) }}"
           class="flex-shrink-0 px-5 py-2.5 rounded-full font-semibold text-sm transition
                  {{ request('category') == $category->id ? 'bg-red-600 text-white shadow-md shadow-red-200' : 'bg-white text-gray-600 border border-gray-200 hover:border-red-400 hover:text-red-600' }}">
            {{ $category->icon }} {{ $category->name }}
            <span class="ml-1 text-xs opacity-70">({{ $category->active_menus_count }})</span>
        </a>
        @endforeach
    </div>
 
    {{-- Info hasil search --}}
    @if(request('search'))
    <div class="mb-6 flex items-center gap-3">
        <p class="text-gray-600">Hasil pencarian untuk: <strong class="text-red-600">"{{ request('search') }}"</strong></p>
        <a href="{{ route('menu') }}" class="text-sm text-gray-400 hover:text-red-600 transition">✕ Hapus filter</a>
    </div>
    @endif
 
    {{-- Grid menu --}}
    @if($menus->isEmpty())
    <div class="text-center py-16">
        <div class="text-6xl mb-4">☕</div>
        <h3 class="text-xl font-bold text-gray-700 mb-2">Menu tidak ditemukan</h3>
        <p class="text-gray-400">Coba kata kunci lain atau lihat semua menu</p>
        <a href="{{ route('menu') }}" class="mt-4 inline-block bg-red-600 text-white px-6 py-2 rounded-full font-semibold hover:bg-red-700 transition">Lihat Semua Menu</a>
    </div>
    @else
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
        @foreach($menus as $index => $menu)
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100
                    transform hover:-translate-y-1 transition-all duration-300
                    animate__animated animate__fadeInUp"
             style="animation-delay: {{ ($index % 8) * 0.05 }}s">
 
            {{-- Gambar menu --}}
            <div class="relative overflow-hidden rounded-t-2xl">
                <img src="{{ $menu->image_url }}"
                     alt="{{ $menu->name }}"
                     class="w-full h-44 object-cover transition-transform duration-500 hover:scale-105"
                     onerror="this.src='https://placehold.co/400x300/dc2626/ffffff?text={{ urlencode($menu->name) }}'">
 
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
 
                {{-- Badge kategori --}}
                <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm text-red-600 text-xs font-bold px-2.5 py-1 rounded-full shadow-sm">
                    {{ $menu->category->name }}
                </span>
            </div>
 
            {{-- Info produk --}}
            <div class="p-4">
                <h3 class="font-bold text-gray-900 text-sm leading-tight mb-1 line-clamp-2">{{ $menu->name }}</h3>
                @if($menu->description)
                <p class="text-gray-400 text-xs mb-2 line-clamp-1">{{ $menu->description }}</p>
                @endif
                <div class="flex items-center justify-between mt-3">
                    <span class="text-red-600 font-black text-base">{{ $menu->price_formatted }}</span>
                    @auth
                    <button
                        onclick="addToCart({{ $menu->id }}, '{{ addslashes($menu->name) }}')"
                        class="btn-add bg-red-600 hover:bg-red-700 text-white text-sm font-bold px-3 py-2 rounded-xl transition flex items-center gap-1">
                        <span>+</span>
                    </button>
                    @else
                    <a href="{{ route('login') }}" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-3 py-2 rounded-xl transition">
                        Pesan
                    </a>
                    @endauth
                </div>
            </div>
        </div>
        @endforeach
    </div>
 
    {{-- Pagination --}}
    <div class="mt-10">
        {{ $menus->links() }}
    </div>
    @endif
</div>
@endsection