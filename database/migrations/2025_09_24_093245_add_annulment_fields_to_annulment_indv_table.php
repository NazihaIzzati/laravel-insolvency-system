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
            $table->string('no_involvency')->nullable()->after('annulment_indv_id');
            $table->string('ic_no')->nullable()->after('name');
            $table->string('ic_no_2')->nullable()->after('ic_no');
            $table->string('court_case_number')->nullable()->after('ic_no_2');
            $table->date('ro_date')->nullable()->after('court_case_number');
            $table->date('ao_date')->nullable()->after('ro_date');
            $table->date('updated_date')->nullable()->after('ao_date');
            $table->string('branch_name')->nullable()->after('updated_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('annulment_indv', function (Blueprint $table) {
            $table->dropColumn([
                'no_involvency',
                'ic_no',
                'ic_no_2',
                'court_case_number',
                'ro_date',
                'ao_date',
                'updated_date',
                'branch_name'
            ]);
        });
    }
};
