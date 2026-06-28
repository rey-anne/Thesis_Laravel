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
        Schema::table('fire_reports', function (Blueprint $table) {
            $table->json('exif_metadata')->nullable()->after('validation_results');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fire_reports', function (Blueprint $table) {
            $table->dropColumn('exif_metadata');
        });
    }
};
