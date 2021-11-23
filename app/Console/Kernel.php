<?php

namespace App\Console;

use App\Models\Campaign\CampaignCron;
use App\Models\Cron;
use App\Models\User\SocialProviders;
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
        $schedule->command(CampaignCron::queueCampaigns())->dailyAt('04:00');
        $schedule->command((new SocialProviders())->getExpiredTokens())->daily();
        $schedule->command((new Cron())->fetchOrderHistory())->dailyAt('02:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
