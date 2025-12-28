<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id(); // logID
            $table->unsignedBigInteger('recordID')->nullable(); // Can be null if action is not on a record
            $table->unsignedBigInteger('performedBy'); // doctorID
            $table->string('actionType'); // e.g., "Created Record", "Updated Patient"
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};