<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\UpdateLoanFundMonth;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('loanfund:update-month')->everyMinute();
        $schedule->command('goodsloan:update-month')->everyMinute();
        $schedule->command('savings:update-savings')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        // $this->commands([
        //     UpdateLoanFundMonth::class,
        // ]);

        require base_path('routes/console.php');
    }
}
