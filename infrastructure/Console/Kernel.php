<?php

namespace Infrastructure\Console;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use ReflectionClass;
use Illuminate\Console\Application as Artisan;
use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;
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
        // $schedule->command('inspire')->hourly();
    }

    protected function commands()
    {
        //
    }
}
