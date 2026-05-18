<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();
            $table->string('description')->nullable();
            $table->decimal('requested_usd', 15, 2);
            $table->decimal('exchange_rate', 15, 2);
            $table->decimal('total_lak', 20, 2);
            $table->decimal('remaining_lak', 20, 2);
            $table->date('date_requested');
            $table->boolean('is_exhausted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};
