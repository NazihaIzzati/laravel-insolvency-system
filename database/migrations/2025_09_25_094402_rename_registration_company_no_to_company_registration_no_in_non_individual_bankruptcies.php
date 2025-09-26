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
        Schema::table('non_individual_bankruptcies', function (Blueprint $table) {
            // Rename registration_company_no to company_registration_no
            $table->renameColumn('registration_company_no', 'company_registration_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('non_individual_bankruptcies', function (Blueprint $table) {
            // Rename back to original name
            $table->renameColumn('company_registration_no', 'registration_company_no');
        });
    }
};