<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->date('date_of_birth')->nullable()->after('phone');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('date_of_birth');
            $table->text('address')->nullable()->after('gender');
            $table->text('medical_history')->nullable()->after('address');
            $table->text('allergies')->nullable()->after('medical_history');
            $table->text('current_medications')->nullable()->after('allergies');
            $table->string('license_number')->nullable()->after('current_medications');
            $table->text('specialization')->nullable()->after('license_number');
            $table->boolean('is_active')->default(true)->after('specialization');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'date_of_birth',
                'gender',
                'address',
                'medical_history',
                'allergies',
                'current_medications',
                'license_number',
                'specialization',
                'is_active',
            ]);
        });
    }
};
