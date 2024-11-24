<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Illuminate\Console\Command;
use Snowfire\Beautymail\Beautymail;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:send-reminders {--silence-logs}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send appointment reminders for today and tomorrow';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $start_time = microtime(true);

        $yesterday = now()->yesterday()->toDateString();
        $tomorrow = now()->tomorrow()->toDateString();
        if (!$this->option('silence-logs')) {
            $this->info("Dates between: {$yesterday} and {$tomorrow}");
        }

        $appointments = Appointment::with(['user'])
            ->whereBetween('picked_date', [$yesterday, $tomorrow])
            ->where('status', 0)
            ->get();

        if (!$this->option('silence-logs')) {
            $this->info("Total pending appointment reminders: {$appointments->count()}");
        }

        foreach ($appointments as $appointment) {
            $beautymail = app()->make(Beautymail::class);
            $beautymail->send('emails.reminder', [
                'appointment' => $appointment
            ], function ($message) use ($appointment) {
                $message
                    ->from(env('MAIL_FROM_ADDRESS'))
                    ->to($appointment->user->email)
                    ->subject('Recordatorio de cita');
            });

            if (!$this->option('silence-logs')) {
                $this->info("Reminder sent to {$appointment->user->email}");
            }
        }

        $end_time = microtime(true);

        $execution_time = $end_time - $start_time;

        $this->info('Appointment reminders sent successfully.');
        $this->info("Elapsed time: $execution_time");
    }
}
