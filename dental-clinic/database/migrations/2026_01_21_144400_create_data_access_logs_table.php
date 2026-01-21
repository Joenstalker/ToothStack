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
        Schema::create('data_access_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('accessed_model'); // Patient, DentalRecord, etc.
            $table->unsignedBigInteger('accessed_id'); // ID of the accessed record
            $table->enum('action', ['viewed', 'created', 'updated', 'deleted', 'exported', 'printed']);
            $table->string('ip_address', 45);
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at');

            // Indexes
            $table->index('tenant_id');
            $table->index('user_id');
            $table->index(['accessed_model', 'accessed_id']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_access_logs');
    }
};
