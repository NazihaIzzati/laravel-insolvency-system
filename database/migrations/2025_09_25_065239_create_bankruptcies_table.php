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
        Schema::create('bankruptcies', function (Blueprint $table) {
            $table->id();
            $table->string('bankruptcy_id')->unique();
            $table->string('case_number')->nullable();
            $table->string('name');
            $table->string('ic_number');
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
            $table->string('status')->default('active'); // active, discharged, annulled
            $table->string('court')->nullable();
            $table->string('trustee')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bankruptcies');
    }
};
