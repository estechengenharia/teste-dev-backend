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
        Schema::create('user_job_offer_applications', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('job_offer_id')->constrained('job_offers');
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
            
            $table->primary(['user_id', 'job_offer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_job_offer_applications');
    }
};
