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
        Schema::table('annulment_indv', function (Blueprint $table) {
            // Drop the unique index first
            $table->dropUnique('staff_staff_id_unique');
        });
        
        Schema::table('annulment_indv', function (Blueprint $table) {
            // Drop old columns that are no longer needed
            $table->dropColumn([
                'annulment_indv_id',
                'annulment_indv_position', 
                'annulment_indv_branch',
                'no_involvency',
                'ic_no_2',
                'court_case_number',
                'ro_date',
                'ao_date',
                'branch_name'
            ]);
            
            // Add new columns
            $table->string('others')->nullable()->after('ic_no');
            $table->string('court_case_no')->nullable()->after('others');
            $table->date('release_date')->nullable()->after('court_case_no');
            $table->string('release_type')->nullable()->after('updated_date');
            $table->string('branch')->nullable()->after('release_type');
            $table->boolean('is_active')->default(true)->after('branch');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('annulment_indv', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn([
                'others',
                'court_case_no', 
                'release_date',
                'release_type',
                'branch',
                'is_active'
            ]);
            
            // Re-add old columns
            $table->string('annulment_indv_id')->nullable();
            $table->string('annulment_indv_position')->nullable();
            $table->string('annulment_indv_branch')->nullable();
            $table->string('no_involvency')->nullable();
            $table->string('ic_no_2')->nullable();
            $table->string('court_case_number')->nullable();
            $table->date('ro_date')->nullable();
            $table->date('ao_date')->nullable();
            $table->string('branch_name')->nullable();
        });
    }
};