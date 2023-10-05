<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Run the UpdatePaidStatusCommand daily, for example, at midnight
        $schedule->command('expenses:update-paid-status')->dailyAt('05:00');
    }

    // REMINDER:
    // Finally, you'll need to configure your server to run Laravel's scheduler at regular intervals. 
    // This typically involves setting up a cron job to execute the schedule:run Artisan command. 
    // You can find more details on how to set up Laravel's scheduler in the Laravel documentation.

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}


