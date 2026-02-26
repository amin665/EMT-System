<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Adding the certificate level for doctors
            if (!Schema::hasColumn('users', 'certificate_level')) {
                $table->string('certificate_level')->nullable()->after('specialization');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('certificate_level');
        });
    }
};