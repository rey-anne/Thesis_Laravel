<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE otps MODIFY purpose ENUM('email_verification', 'password_reset', 'login') NOT NULL");

        Schema::table('otps', function (Blueprint $table) {
            $table->enum('channel', ['email', 'sms'])->default('email')->after('purpose');
            $table->string('phone')->nullable()->after('channel');
        });
    }

    public function down(): void
    {
        Schema::table('otps', function (Blueprint $table) {
            $table->dropColumn(['channel', 'phone']);
        });

        DB::statement("ALTER TABLE otps MODIFY purpose ENUM('email_verification', 'password_reset') NOT NULL");
    }
};
