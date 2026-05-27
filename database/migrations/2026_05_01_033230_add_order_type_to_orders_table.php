<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Tipe order: delivery atau takeaway
            $table->enum('order_type', ['delivery', 'takeaway'])
                  ->default('delivery')
                  ->after('status');

            // Waktu ambil (hanya untuk takeaway)
            $table->time('pickup_time')->nullable()->after('order_type');

            // Nama pengambil (hanya untuk takeaway)
            $table->string('pickup_name')->nullable()->after('pickup_time');

            // delivery_address dan delivery_name jadi nullable
            // karena takeaway tidak butuh alamat
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['order_type', 'pickup_time', 'pickup_name']);
        });
    }
};