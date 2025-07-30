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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to users table
            $table->foreignId('internship_program_id')->constrained('internship_programs')->onDelete('cascade'); // Foreign key to internship_programs table
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade'); // Foreign key to schools table
            $table->foreignId('school_supervisor_id')->constrained('school_supervisors')->onDelete('cascade')->nullable(); // Nullable Foreign key to school_supervisors table
            $table->string('nis', 20)->unique(); // Unique NIS for students
            $table->string('class', 30)->nullable(); // Nullable Class for students
            $table->text('address')->nullable(); // Nullable Address for students
            $table->string('phone', 15)->nullable(); // Nullable Phone for students
            $table->string('hobby', 64)->nullable(); // Nullable Hobby for students
            $table->timestamps();

            // Additional indexes for better performance
            $table->index('internship_program_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
