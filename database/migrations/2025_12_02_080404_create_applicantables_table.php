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
        Schema::create('applicantables', function (Blueprint $table) {
            $table->id();
            // applicant reference (normal)
            $table->foreignId('applicant_id')
                ->constrained('applicants')
                ->cascadeOnDelete();

            // normal FK job_id (you need this)
            $table->foreignId('job_id')
                ->constrained('job_posts')
                ->cascadeOnDelete();

            // polymorphic relation (using morphs)
            $table->morphs('applicantable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicantables');
    }
};
