<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShippingController extends Controller
{
    public function calculate(Request $request)
    {
        $address = $request->address;

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Alamat kosong'
            ]);
        }

        // ================================
        // KOORDINAT TOKO
        // ================================
        $storeLat = 1.0456;
        $storeLng = 104.0305;

        // ================================
        // CARI KOORDINAT ALAMAT USER
        // ================================
        $response = Http::withHeaders([
            'User-Agent' => 'ToneCoffeeApp/1.0'
        ])->get('https://nominatim.openstreetmap.org/search', [
            'q' => $address,
            'format' => 'json',
            'limit' => 1
        ]);

        $data = $response->json();

        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Alamat tidak ditemukan'
            ]);
        }

        $userLat = $data[0]['lat'];
        $userLng = $data[0]['lon'];

        // ================================
        // HITUNG JARAK (KM)
        // ================================
        $distance = $this->calculateDistance(
            $storeLat,
            $storeLng,
            $userLat,
            $userLng
        );

        // ================================
        // HITUNG ONGKIR
        // ================================
        $shippingCost = max(5000, round($distance * 3000));

        return response()->json([
            'success' => true,
            'distance' => round($distance, 2),
            'shipping_cost' => $shippingCost,
            'shipping_cost_format' =>
                'Rp' . number_format($shippingCost, 0, ',', '.')
        ]);
    }

    // ==========================================
    // RUMUS HAVERSINE
    // ==========================================
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earth = 6371;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a =
            sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) *
            cos(deg2rad($lat2)) *
            sin($dLon / 2) *
            sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earth * $c;
    }
}