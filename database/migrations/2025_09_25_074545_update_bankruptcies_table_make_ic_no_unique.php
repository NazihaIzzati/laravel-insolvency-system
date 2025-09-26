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
            // Add unique constraint to ic_no
            $table->unique('ic_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bankruptcies', function (Blueprint $table) {
            // Remove unique constraint from ic_no
            $table->dropUnique(['ic_no']);
        });
    }
};