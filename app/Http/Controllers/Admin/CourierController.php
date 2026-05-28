<?php

// ============================================================
// FILE: app/Http/Controllers/Admin/CourierController.php
// ============================================================

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use Illuminate\Http\Request;
use Cloudinary\Cloudinary;

class CourierController extends Controller
{
    public function index()
    {
        $couriers = Courier::withCount('orders')->latest()->paginate(15);
        return view('admin.courier.index', compact('couriers'));
    }

    public function create()
    {
        return view('admin.courier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:100',
            'phone'          => 'required|string|max:20',
            'vehicle_number' => 'required|string|max:20',
            'photo'          => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'status'         => 'required|in:online,offline',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {

            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key'    => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ],
                'url' => [
                    'secure' => true,
                ],
            ]);

            $uploadedFile = $cloudinary->uploadApi()->upload(
                $request->file('photo')->getRealPath(),
                [
                    'folder' => 'couriers'
                ]
            );

            $data['photo'] = $uploadedFile['secure_url'];
        }

        Courier::create($data);

        return redirect()->route('admin.couriers.index')
            ->with('success', 'Kurir berhasil ditambahkan!');
    }

    public function edit(Courier $courier)
    {
        return view('admin.courier.edit', compact('courier'));
    }

    public function update(Request $request, Courier $courier)
    {
        $request->validate([
            'name'           => 'required|string|max:100',
            'phone'          => 'required|string|max:20',
            'vehicle_number' => 'required|string|max:20',
            'photo'          => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'status'         => 'required|in:online,offline',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('couriers', 'public');
        }

        $courier->update($data);

        return redirect()->route('admin.couriers.index')
            ->with('success', 'Data kurir berhasil diperbarui!');
    }

    public function destroy(Courier $courier)
    {
        $courier->delete();
        return redirect()->route('admin.couriers.index')
            ->with('success', 'Kurir berhasil dihapus.');
    }

    public function toggleStatus(Courier $courier)
    {
        $courier->toggleStatus();

        return response()->json([
            'success' => true,
            'status'  => $courier->status,
            'message' => "Kurir {$courier->name} sekarang {$courier->status}",
        ]);
    }
}
