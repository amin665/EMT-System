<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Mail\AppointmentReminder;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send email reminders for appointments happening in 24 hours';

    public function handle()
    {
        $startWindow = Carbon::now()->addDay()->subMinutes(30);
        $endWindow   = Carbon::now()->addDay()->addMinutes(30);

        $this->info("Checking appointments between: " . $startWindow . " and " . $endWindow);

        $appointments = Appointment::whereBetween('date', [$startWindow, $endWindow])
                                   ->where('status', '!=', 'Canceled')
                                   ->where('sms_sent', false)
                                   ->with(['patient', 'doctor'])
                                   ->get();

        foreach ($appointments as $apt) {
            if ($apt->patient && $apt->patient->email) {
                
                $template = $apt->doctor->telegram_message_template; 

                $message = str_replace('{patient}', $apt->patient->fullName, $template);
                $message = str_replace('{time}', $apt->date->format('H:i'), $message);

                try {
                    Mail::to($apt->patient->email)->send(new AppointmentReminder($message));
                    
                    $apt->update(['sms_sent' => true]);
                    
                    $this->info("Sent reminder to: " . $apt->patient->fullName);
                } catch (\Exception $e) {
                    $this->error("Failed to send to " . $apt->patient->fullName . ": " . $e->getMessage());
                }
            }
        }
    }
}