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
        Schema::create('non_individual_bankruptcies', function (Blueprint $table) {
            $table->id();
            $table->string('insolvency_no')->unique();
            $table->string('company_name');
            $table->string('registration_no')->unique(); // Company registration number instead of IC
            $table->string('others')->nullable();
            $table->string('court_case_no')->nullable();
            $table->date('ro_date')->nullable();
            $table->date('ao_date')->nullable();
            $table->date('updated_date')->nullable();
            $table->string('branch')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('non_individual_bankruptcies');
    }
};