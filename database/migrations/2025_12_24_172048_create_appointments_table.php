<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id(); // appointmentID
            $table->unsignedBigInteger('patientID');
            $table->unsignedBigInteger('doctorID');
            $table->dateTime('date'); // Includes time
            $table->enum('status', ['Scheduled', 'Done', 'Delayed', 'Canceled'])->default('Scheduled');
            $table->boolean('sms_sent')->default(false);
            $table->timestamps();

            $table->foreign('patientID')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('doctorID')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};