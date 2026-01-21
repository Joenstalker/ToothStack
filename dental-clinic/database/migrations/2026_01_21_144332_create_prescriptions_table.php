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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('dental_record_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('prescribed_by')->constrained('users')->onDelete('cascade');
            $table->string('medication_name');
            $table->string('dosage');
            $table->string('frequency'); // e.g., "3 times daily"
            $table->integer('duration_days');
            $table->text('instructions')->nullable();
            $table->timestamp('prescribed_at');
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('tenant_id');
            $table->index('patient_id');
            $table->index('prescribed_by');
            $table->index('prescribed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
