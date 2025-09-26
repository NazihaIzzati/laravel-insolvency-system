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
            // Rename registration_no to registration_company_no
            $table->renameColumn('registration_no', 'registration_company_no');
            
            // Rename ro_date to date_of_winding_up_resolution
            $table->renameColumn('ro_date', 'date_of_winding_up_resolution');
            
            // Remove ao_date column as it's not in the specified structure
            $table->dropColumn('ao_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('non_individual_bankruptcies', function (Blueprint $table) {
            // Rename back to original names
            $table->renameColumn('registration_company_no', 'registration_no');
            $table->renameColumn('date_of_winding_up_resolution', 'ro_date');
            
            // Add back ao_date column
            $table->date('ao_date')->nullable()->after('date_of_winding_up_resolution');
        });
    }
};