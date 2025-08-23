<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Creates the 'students' table to store student information.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('internship_program_id')->constrained('internship_programs')->onDelete('cascade');
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->foreignId('school_supervisor_id')->constrained('school_supervisors')->onDelete('cascade')->nullable();
            $table->string('nis', 20)->unique();
            $table->string('class', 30)->nullable();
            $table->text('address')->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('hobby', 64)->nullable();
            $table->timestamps();
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
