<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
                    ->to($this->appointment->user->email)
                    ->subject('Recordatorio de cita')
                    ->view('emails.reminder')
                    ->with(['appointment' => $this->appointment, 'css' => [], 'logo' => [], 'unsubscribe' => '']);
    }
}