<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fire_reports', function (Blueprint $table) {
            $table->dropIndex(['ai_duplicate_of_report_id']);
            $table->dropColumn([
                'ai_fire_level',
                'ai_authenticity_score',
                'ai_is_duplicate',
                'ai_duplicate_of_report_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('fire_reports', function (Blueprint $table) {
            $table->string('ai_fire_level')->nullable();
            $table->decimal('ai_authenticity_score', 5, 2)->nullable();
            $table->boolean('ai_is_duplicate')->default(false);
            $table->unsignedBigInteger('ai_duplicate_of_report_id')->nullable();
            $table->index('ai_duplicate_of_report_id');
        });
    }
};
