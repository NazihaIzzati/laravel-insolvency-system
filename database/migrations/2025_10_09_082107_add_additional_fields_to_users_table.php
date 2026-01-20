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
        Schema::table('users', function (Blueprint $table) {
            $table->string('login_id')->nullable()->after('email');
            $table->string('login_name')->nullable()->after('login_id');
            $table->string('officer_level')->nullable()->after('role');
            $table->string('branch_code')->nullable()->after('officer_level');
            $table->string('status')->default('active')->after('is_active');
            $table->date('expiry_date')->nullable()->after('status');
            $table->timestamp('pwdchange_date')->nullable()->after('expiry_date');
            $table->timestamp('last_modified_date')->nullable()->after('pwdchange_date');
            $table->string('last_modified_user')->nullable()->after('last_modified_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'login_id',
                'login_name',
                'officer_level',
                'branch_code',
                'status',
                'expiry_date',
                'pwdchange_date',
                'last_modified_date',
                'last_modified_user'
            ]);
        });
    }
};