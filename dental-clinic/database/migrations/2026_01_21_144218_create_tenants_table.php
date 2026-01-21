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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Clinic Name
            $table->string('slug')->unique(); // For subdomains (e.g., clinicA)
            $table->string('domain')->nullable()->unique(); // Custom domain
            $table->enum('subscription_plan', ['basic', 'pro', 'ultimate'])->default('basic');
            $table->enum('subscription_status', ['active', 'suspended', 'cancelled', 'trial'])->default('trial');
            $table->timestamp('subscription_ends_at')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->integer('max_users')->default(5); // Based on plan
            $table->integer('max_patients')->default(100); // Based on plan
            $table->json('features')->nullable(); // Enabled features based on plan
            $table->json('settings')->nullable(); // Clinic-specific settings
            $table->json('branding')->nullable(); // Logo, colors, theme
            $table->string('database_connection')->nullable(); // For dedicated DB (enterprise)
            $table->boolean('is_active')->default(true);
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->default('Philippines');
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('slug');
            $table->index('subscription_status');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
