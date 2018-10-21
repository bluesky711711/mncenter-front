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
        Commands\updatePrice::class,
        Commands\updateWallet::class,
        Commands\updateTransaction::class,
        Commands\updateSale::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('updatePrice')
                 ->everyFiveMinutes();
        $schedule->command('updateWallet')
                 ->everyFiveMinutes();
        $schedule->command('updateTransaction')
                 ->everyFiveMinutes();
        $schedule->command('updateSale')
                 ->everyFiveMinutes();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
