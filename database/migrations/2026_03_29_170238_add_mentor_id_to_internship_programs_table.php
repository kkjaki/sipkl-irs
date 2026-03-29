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
        Schema::table('internship_programs', function (Blueprint $table) {
            $table->foreignId('mentor_id')->nullable()->after('industry_id')->constrained('mentors')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internship_programs', function (Blueprint $table) {
            $table->dropForeign(['mentor_id']);
            $table->dropColumn('mentor_id');
        });
    }
};
