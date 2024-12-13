<?php

namespace App\Console\Commands;

use App\Mail\AppointmentReminder;
use App\Models\Appointment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
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
            Mail::send(new AppointmentReminder($appointment));

            if (!$this->option('silence-logs')) {
                $this->info("Reminder sent to {$appointment->user->email}");
            }

            sleep(2);
        }

        $end_time = microtime(true);

        $execution_time = $end_time - $start_time;

        $this->info('Appointment reminders sent successfully.');
        $this->info("Elapsed time: $execution_time");
    }
}
