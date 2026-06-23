<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('firefighter_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('bfp_id_number')->nullable();
            $table->string('official_email')->nullable();
            $table->string('official_contact_number')->nullable();
            $table->string('duty_status')->nullable();
            $table->string('rank')->nullable();
            $table->string('unit_division')->nullable();
            $table->unsignedBigInteger('assigned_fire_station_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('firefighter_profiles');
    }
};
