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
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\SimpleCrudCreator::class,
        \App\Console\Commands\CreateModel::class,
        \App\Console\Commands\CreateController::class,
        \App\Console\Commands\GenerateValidation::class,
        \App\Console\Commands\GenerateCrud::class,
        \App\Console\Commands\CreateAuthCrud::class,
        \App\Console\Commands\CreateFormFields::class,
        \App\Console\Commands\GenerateSeeder::class,
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
