<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\InitCustomer::class,
        \App\Console\Commands\InitProject::class,
        \App\Console\Commands\InitTask::class,
        \App\Console\Commands\SyncProject::class,
        \App\Console\Commands\SyncTask::class,
        \App\Console\Commands\SyncCustomer::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
/*        $schedule->command('inspire')
                 ->hourly();*/
        $schedule->command('command:sync_task')->everyTenMinutes();

        $schedule->call(function () {
            Log::info('任务执行记录'.date("Y-m-d H:i:s",strtotime("now")));
        })->everyFiveMinutes();
    }
}
