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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->char("subject_name", 50);
            $table->char("school_year", 9);
            $table->enum("semester", [1, 2, 3]);
            $table->foreignId("instructor_id")->constrained("users")->onDelete("cascade")->onUpdate("cascade");
            $table->char("report", 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
