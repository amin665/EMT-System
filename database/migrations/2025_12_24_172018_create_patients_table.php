<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id(); // patientID
            $table->unsignedBigInteger('createdBy'); // doctorID
            $table->string('fullName');
            $table->string('phoneNumber');
            $table->date('dob');
            $table->text('medicalHistory')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('createdBy')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};