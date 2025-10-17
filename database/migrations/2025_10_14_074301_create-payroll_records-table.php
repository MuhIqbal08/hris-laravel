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
        Schema::create('payroll_records', function (Blueprint $table) {
            $table->uuid('uuid')->primary()->unique();
            $table->foreignUuid('employee_id')->references('uuid')->on('employees')->onDelete('cascade');
            $table->integer('period_month');
            $table->integer('period_year');
            $table->integer('working_days');
            $table->decimal('net_salary', 10, 2);
            $table->json('details');
            $table->boolean('is_paid')->default(false);
            // $table->decimal('payroll_amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
