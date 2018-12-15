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
        Commands\createWallet::class,
        Commands\updateTransaction::class,
        Commands\updateSale::class,
        Commands\updateReward::class,
        Commands\testCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('updatePrice')->everyMinute();
        // $schedule->command('updateWallet')->everyMinute();
        // $schedule->command('updateTransaction')->everyMinute();
        // $schedule->command('updateSale')->everyMinute();
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
