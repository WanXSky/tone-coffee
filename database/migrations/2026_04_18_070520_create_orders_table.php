<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// FILE: database/migrations/2024_01_01_000004_create_orders_table.php
// ============================================================
 
return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('courier_id')->nullable()->constrained()->onDelete('set null');
            $table->string('order_number')->unique();
            $table->enum('status', [
                'pending',
                'processing',
                'shipped',
                'completed',
                'cancelled'
            ])->default('pending');
            $table->text('delivery_address');
            $table->string('delivery_name');
            $table->string('delivery_phone', 20);
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('delivery_fee', 10, 2)->default(5000);
            $table->decimal('total_amount', 10, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
