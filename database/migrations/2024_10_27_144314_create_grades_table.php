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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->char("midterm",3)->nullable();
            $table->char("final", 3)->nullable();
            $table->enum("status", ["active", "dropped"]);
            $table->foreignId("subject_id")->constrained("subjects")->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("student_id")->constrained("students")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
