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
        Schema::table('bankruptcies', function (Blueprint $table) {
            // Remove unnecessary columns
            $table->dropColumn([
                'case_number',
                'ic_number_2',
                'address',
                'phone',
                'email',
                'occupation',
                'employer',
                'total_debt',
                'total_assets',
                'bankruptcy_date',
                'discharge_date',
                'status',
                'court',
                'trustee',
                'notes'
            ]);
            
            // Rename bankruptcy_id to insolvency_no
            $table->renameColumn('bankruptcy_id', 'insolvency_no');
            
            // Rename ic_number to ic_no
            $table->renameColumn('ic_number', 'ic_no');
            
            // Add new required columns
            $table->string('others')->nullable()->after('ic_no');
            $table->string('court_case_no')->nullable()->after('others');
            $table->date('ro_date')->nullable()->after('court_case_no');
            $table->date('ao_date')->nullable()->after('ro_date');
            $table->date('updated_date')->nullable()->after('ao_date');
            $table->string('branch')->nullable()->after('updated_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bankruptcies', function (Blueprint $table) {
            // Restore original columns
            $table->string('case_number')->nullable();
            $table->string('ic_number_2')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('occupation')->nullable();
            $table->string('employer')->nullable();
            $table->decimal('total_debt', 15, 2)->nullable();
            $table->decimal('total_assets', 15, 2)->nullable();
            $table->date('bankruptcy_date')->nullable();
            $table->date('discharge_date')->nullable();
            $table->string('status')->default('active');
            $table->string('court')->nullable();
            $table->string('trustee')->nullable();
            $table->text('notes')->nullable();
            
            // Rename back to original names
            $table->renameColumn('insolvency_no', 'bankruptcy_id');
            $table->renameColumn('ic_no', 'ic_number');
            
            // Remove new columns
            $table->dropColumn([
                'others',
                'court_case_no',
                'ro_date',
                'ao_date',
                'updated_date',
                'branch'
            ]);
        });
    }
};
