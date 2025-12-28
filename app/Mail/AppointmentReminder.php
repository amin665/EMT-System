<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $messageContent;

    public function __construct($messageContent)
    {
        $this->messageContent = $messageContent;
    }

    public function build()
    {
        return $this->subject('تذكير بموعدك - EMT System')
                    ->from('aminosman.abbas@gmail.com', 'Dr. Amin Osman')
                    ->html('<div style="text-align: right; direction: rtl; font-family: Arial;">' . nl2br($this->messageContent) . '</div>');
    }
}