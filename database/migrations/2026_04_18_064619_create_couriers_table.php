<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// FILE: database/migrations/2024_01_01_000003_create_couriers_table.php
// ============================================================
 
return new class extends Migration {
    public function up(): void
    {
        Schema::create('couriers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 20);
            $table->string('vehicle_number', 20);
            $table->string('photo')->nullable();
            $table->enum('status', ['online', 'offline'])->default('offline');
            $table->timestamps();
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('couriers');
    }
};
