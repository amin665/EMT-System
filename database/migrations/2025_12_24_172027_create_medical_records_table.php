<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id(); // recordID
            $table->unsignedBigInteger('patientID');
            $table->unsignedBigInteger('doctorID');
            $table->text('diagnosis');
            $table->text('prescription');
            $table->text('followUpNotes')->nullable();
            $table->timestamps();

            $table->foreign('patientID')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('doctorID')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};