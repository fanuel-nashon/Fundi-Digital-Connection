<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->text('comment')->nullable()->after('rating');
        });

        // Extend the status enum to include 'declined'
        DB::statement("ALTER TABLE job_requests MODIFY COLUMN status ENUM('pending','accepted','declined','complete','reviewed') NOT NULL");
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('comment');
        });

        DB::statement("ALTER TABLE job_requests MODIFY COLUMN status ENUM('pending','accepted','complete','reviewed') NOT NULL");
    }
};
