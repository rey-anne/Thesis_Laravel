<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('id_number')->nullable();
            $table->string('rank')->nullable();
            $table->unsignedBigInteger('assigned_fire_station_id')->nullable();
            $table->string('command_level')->nullable();
            $table->string('unit_division_handled')->nullable();
            $table->text('managed_units')->nullable();
            $table->string('area_of_jurisdiction')->nullable();
            $table->string('official_email')->nullable();
            $table->string('official_contact_number')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_profiles');
    }
};
