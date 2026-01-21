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
        Schema::create('dental_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('dentist_id')->constrained('users')->onDelete('cascade');
            $table->date('date');
            $table->text('chief_complaint')->nullable();
            $table->text('diagnosis')->nullable();
            $table->json('treatment_plan')->nullable(); // Array of planned treatments
            $table->json('procedures_done')->nullable(); // Array of completed procedures
            $table->json('prescriptions')->nullable(); // Array of prescriptions
            $table->json('tooth_chart')->nullable(); // Visual tooth chart data
            $table->json('attachments')->nullable(); // X-rays, photos URLs
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('tenant_id');
            $table->index('patient_id');
            $table->index('dentist_id');
            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dental_records');
    }
};
