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
        //
        Schema::create('employees', function (Blueprint $table) {
            $table->uuid('uuid')->primary()->unique();
            $table->foreignUuid('user_id')->references('uuid')->on('users')->onDelete('cascade');
            $table->string('employee_id');
            $table->string('position');
            $table->foreignUuid('department_id')->references('uuid')->on('departments')->onDelete('cascade');
            $table->date('join_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('employees');
    }
};
