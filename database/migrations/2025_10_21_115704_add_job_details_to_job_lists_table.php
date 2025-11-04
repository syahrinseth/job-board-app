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
        Schema::table('job_lists', function (Blueprint $table) {
            $table->text('requirements')->nullable()->after('description');
            $table->string('salary_range')->nullable()->after('requirements');
            $table->enum('job_type', ['full-time', 'part-time', 'contract', 'freelance', 'internship'])
                  ->default('full-time')->after('salary_range');
            $table->enum('work_type', ['remote', 'onsite', 'hybrid'])
                  ->default('onsite')->after('job_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_lists', function (Blueprint $table) {
            $table->dropColumn(['requirements', 'salary_range', 'job_type', 'work_type']);
        });
    }
};
