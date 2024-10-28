<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $recipient; 

    public function __construct($appointment, $recipient)
    {
        $this->appointment = $appointment;
        $this->recipient = $recipient;
    }

    public function build()
    {
        return $this->subject('New Appointment Request')
            ->view('email.email-format')
            ->with([
                'appointment' => $this->appointment,
                'recipient' => $this->recipient, 
            ]);
    }
}
