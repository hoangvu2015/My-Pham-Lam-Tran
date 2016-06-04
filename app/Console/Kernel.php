<?php

namespace Antoree\Console;


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
        \Antoree\Console\Commands\Inspire::class,
        \Antoree\Console\Commands\ChangeStatusTeacher::class,
        \Antoree\Console\Commands\StudentTmp::class,
        \Antoree\Console\Commands\UpdateViewBlog::class,
        \Antoree\Console\Commands\UpdateApproverTeacher::class,
        \Antoree\Console\Commands\CopyCountryToNationlity::class,
        \Antoree\Console\Commands\UpdateStudents::class,
        \Antoree\Console\Commands\CreateContactOdoo::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();
    }
}
