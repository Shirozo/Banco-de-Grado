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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->char('first_name', length:50);
            $table->char('last_name', length:50);
            $table->char('middle_name', length:50);
            $table->char("student_id", 8);
            $table->char("course", 50);
            $table->enum("year", [1, 2, 3, 4]);
            $table->char("section", 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
