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
        Schema::rename('staff', 'annulment_indv');
        
        Schema::table('annulment_indv', function (Blueprint $table) {
            $table->renameColumn('staff_id', 'annulment_indv_id');
            $table->renameColumn('staff_position', 'annulment_indv_position');
            $table->renameColumn('staff_branch', 'annulment_indv_branch');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('annulment_indv', function (Blueprint $table) {
            $table->renameColumn('annulment_indv_id', 'staff_id');
            $table->renameColumn('annulment_indv_position', 'staff_position');
            $table->renameColumn('annulment_indv_branch', 'staff_branch');
        });
        
        Schema::rename('annulment_indv', 'staff');
    }
};
