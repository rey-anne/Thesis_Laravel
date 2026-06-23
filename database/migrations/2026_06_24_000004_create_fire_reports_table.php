<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fire_reports', function (Blueprint $table) {
            $table->id();
            $table->string('reporter_contact')->nullable();

            $table->boolean('has_gps_pin')->default(false);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->boolean('has_file_attachment')->default(false);
            $table->string('photo_path')->nullable();
            $table->json('photo_metadata')->nullable();

            $table->string('ai_fire_level')->nullable();
            $table->decimal('ai_authenticity_score', 5, 2)->nullable();
            $table->boolean('ai_is_duplicate')->default(false);
            $table->unsignedBigInteger('ai_duplicate_of_report_id')->nullable();

            $table->string('status')->default('active');
            $table->boolean('verified_by_crowdsourcing')->default(false);

            $table->timestamp('reported_at')->nullable();
            $table->timestamp('extinguished_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->boolean('is_archived')->default(false);

            $table->timestamps();

            $table->index('ai_duplicate_of_report_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fire_reports');
    }
};
