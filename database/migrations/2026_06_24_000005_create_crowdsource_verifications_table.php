<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crowdsource_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fire_report_id')->constrained('fire_reports')->cascadeOnDelete();
            $table->decimal('verifier_latitude', 10, 7)->nullable();
            $table->decimal('verifier_longitude', 10, 7)->nullable();
            $table->string('verification_photo_path');
            $table->timestamp('submitted_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crowdsource_verifications');
    }
};
