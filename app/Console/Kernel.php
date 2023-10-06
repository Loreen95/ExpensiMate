<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\SendNotifications::class,
    ];
    
    protected function schedule(Schedule $schedule)
    {
        // Schedule the 'send:notifications' command to run daily at 8:00 AM
        $schedule->command('notifications:send')->dailyAt('08:00');
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


