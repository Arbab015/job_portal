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
        Schema::dropIfExists('job_applicants');
        Schema::dropIfExists('vice_chancellors');
        Schema::dropIfExists('professors');
        Schema::dropIfExists('hods');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
