<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->command('ramitours:updateNoFlights')->hourlyAt(8);
        $schedule->command('ramitours:updateNoFlights')->hourlyAt(23);
        $schedule->command('ramitours:updateNoFlights')->hourlyAt(38);
        $schedule->command('ramitours:updateNoFlights')->hourlyAt(52);
        $schedule->command('ramitours:updatePackages')->everyFifteenMinutes();
        $schedule->command('ramitours:check_alerts')->dailyAt('07:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}