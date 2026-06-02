<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_requests', function (Blueprint $table) {
            $table->date('deadline')->nullable()->after('scheduled_date');
            $table->unsignedTinyInteger('progress')->default(0)->after('deadline');
        });

        // Extend status enum to include in_progress
        \Illuminate\Support\Facades\DB::statement(
            "ALTER TABLE job_requests MODIFY COLUMN status
             ENUM('pending','accepted','in_progress','declined','complete','reviewed') NOT NULL"
        );
    }

    public function down(): void
    {
        Schema::table('job_requests', function (Blueprint $table) {
            $table->dropColumn(['deadline', 'progress']);
        });

        \Illuminate\Support\Facades\DB::statement(
            "ALTER TABLE job_requests MODIFY COLUMN status
             ENUM('pending','accepted','declined','complete','reviewed') NOT NULL"
        );
    }
};
