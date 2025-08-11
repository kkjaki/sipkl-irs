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
        Schema::create('internship_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industry_id')->constrained('industries')->onDelete('cascade'); // Foreign key to industries table
            $table->string('name'); // Name of the internship program
            $table->date('start_date'); // Start date of the internship program
            $table->date('end_date'); // End date of the internship program
            $table->string('invitation_code')->unique(); // Unique invitation code for the internship program
            $table->boolean('is_active')->default(true); // Active status of the internship program
            $table->timestamps();

            // Additional indexes for better performance
            $table->index(['industry_id', 'is_active']);
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_programs');
    }
};
