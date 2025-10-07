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
        Schema::create('annulment_non_indv', function (Blueprint $table) {
            $table->id();
            $table->string('insolvency_no')->unique();
            $table->string('company_name');
            $table->string('company_registration_no');
            $table->string('others')->nullable();
            $table->string('court_case_no')->nullable();
            $table->date('release_date')->nullable();
            $table->string('updated_date')->nullable();
            $table->string('release_type')->nullable();
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
        Schema::dropIfExists('annulment_non_indv');
    }
};