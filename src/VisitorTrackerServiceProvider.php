<?php

namespace Kitoko\VisitorTracker;
use Carbon\Carbon;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Kitoko\VisitorTracker\Models\Visitor;
use Kitoko\VisitorTracker\Middleware\TrackVisitor;
use Kitoko\VisitorTracker\Console\CleanupVisitorData;
use Kitoko\VisitorTracker\Services\VisitorTrackerService;
use Kitoko\VisitorTracker\ViewComposers\VisitorStatsComposer;

class VisitorTrackerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/visitor-tracker.php', 'visitor-tracker');
        $this->app->singleton('visitor-tracker', function () {
            return new VisitorTrackerService();
        });
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

