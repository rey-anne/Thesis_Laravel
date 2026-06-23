<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fire_report_id')->constrained('fire_reports')->cascadeOnDelete();

            // Snapshot the responsible personnel's name/ID at submission time,
            // so the official record doesn't change if their profile is edited later.
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('personnel_name');
            $table->string('id_number')->nullable();

            $table->text('incident_summary');
            $table->text('action_taken');
            $table->timestamp('extinguished_at')->nullable();
            $table->text('remarks')->nullable();

            $table->string('report_file_path')->nullable();
            $table->string('report_file_original_name')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_operations');
    }
};
