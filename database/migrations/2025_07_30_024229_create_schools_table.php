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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industry_id')->constrained('industries')->onDelete('cascade'); // Foreign key to industries table
            $table->string('name'); // Name of the school
            $table->text('address')->nullable(); // Nullable Address for the school
            $table->string('phone', 15)->nullable(); // Nullable Phone for the school
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
