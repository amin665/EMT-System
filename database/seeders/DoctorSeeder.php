<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default doctor account
        User::firstOrCreate(
            ['username' => 'doctor'], // Check by username to avoid duplicates
            [
                'name' => 'Dr. Amin Osman',
                'email' => 'Amin@emt.ly',
                'password' => 'password', // The password will be hashed by the model cast
                'specialization' => 'General Medicine',
                'telegram_message_template' => 'Hello {patient}, your appointment is tomorrow at {time}.',
            ]
        );
    }
}