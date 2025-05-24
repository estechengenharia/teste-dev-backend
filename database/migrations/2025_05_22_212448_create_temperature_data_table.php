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
        Schema::create('temperature_data', function (Blueprint $table) {
            $table->id();
            $table->dateTime('recorded_at');
            $table->decimal('temperature', 5, 1);
            $table->timestamps();
            $table->index('recorded_at');
            $table->index('temperature');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temperature_data');
    }
};
