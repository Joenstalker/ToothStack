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
        // Add tenant_id to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('tenant_id')->after('id')->nullable()->constrained()->onDelete('cascade');
            $table->index('tenant_id');
        });

        // Add tenant_id to services table
        Schema::table('services', function (Blueprint $table) {
            $table->foreignId('tenant_id')->after('id')->nullable()->constrained()->onDelete('cascade');
            $table->index('tenant_id');
        });

        // Add tenant_id to schedules table
        Schema::table('schedules', function (Blueprint $table) {
            $table->foreignId('tenant_id')->after('id')->nullable()->constrained()->onDelete('cascade');
            $table->index('tenant_id');
        });

        // Add tenant_id to appointments table
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreignId('tenant_id')->after('id')->nullable()->constrained()->onDelete('cascade');
            $table->index('tenant_id');
        });

        // Add tenant_id to concerns table
        Schema::table('concerns', function (Blueprint $table) {
            $table->foreignId('tenant_id')->after('id')->nullable()->constrained()->onDelete('cascade');
            $table->index('tenant_id');
        });

        // Add tenant_id to audit_logs table
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->foreignId('tenant_id')->after('id')->nullable()->constrained()->onDelete('cascade');
            $table->index('tenant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
        });

        Schema::table('concerns', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
        });

        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
        });
    }
};
