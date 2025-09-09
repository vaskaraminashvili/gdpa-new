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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained('trainings')->onDelete('cascade');
            $table->string('name');
            $table->string('personal_id');
            $table->string('phone');
            $table->string('certificate_number')->nullable();
            $table->date('certificate_date')->nullable();
            $table->string('specialty')->nullable();
            $table->string('work_place')->nullable();
            $table->text('work_place_address')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Ensure unique personal_id per training
            $table->unique(['training_id', 'personal_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
