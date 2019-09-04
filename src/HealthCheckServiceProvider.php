<?php

namespace Ambientia\HealthCheck;

use Ambientia\HealthCheck\Console\Commands\Heartbeat as HeartbeatCommand;
use Ambientia\HealthCheck\Jobs\Heartbeat as HeartbeatJob;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class HealthCheckServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register()
    {
        $this->app->make('Ambientia\HealthCheck\Http\Controllers\HealthCheckController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        if (!$this->app->runningInConsole() || $this->app->environment() == 'testing') {
            return;
        }

        $this->commands(HeartbeatCommand::class);

        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->job(new HeartbeatJob())->everyMinute();
            $schedule->command('healthcheck:heartbeat')->everyMinute();
        });
    }
}
