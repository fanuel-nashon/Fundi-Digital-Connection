<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_requests', function (Blueprint $table) {
            $table->dropColumn(['customer_id', 'tradesperson_id']);
        });

        Schema::table('job_requests', function (Blueprint $table) {
            $table->foreignId('customer_id')->after('id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tradesperson_id')->after('customer_id')->constrained('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('job_requests', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['tradesperson_id']);
            $table->dropColumn(['customer_id', 'tradesperson_id']);
        });

        Schema::table('job_requests', function (Blueprint $table) {
            $table->string('customer_id');
            $table->string('tradesperson_id');
        });
    }
};
