<?php

namespace Kitoko\VisitorTracker;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Kitoko\VisitorTracker\Middleware\TrackVisitor;
use Kitoko\VisitorTracker\ViewComposers\VisitorStatsComposer;
use Kitoko\VisitorTracker\Console\CleanupVisitorData;

class VisitorTrackerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/visitor-tracker.php', 'visitor-tracker');
    }

    public function boot(Router $router)
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $router->pushMiddlewareToGroup('web', TrackVisitor::class);

        View::composer('*', VisitorStatsComposer::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                CleanupVisitorData::class,
            ]);

            $this->publishes([
                __DIR__.'/../config/visitor-tracker.php' => App::configPath('visitor-tracker.php'),
            ], 'visitor-tracker-config');
        }
    }
}

