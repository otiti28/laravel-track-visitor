<?php
namespace Kitoko\VisitorTracker\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\App;
use Kitoko\VisitorTracker\Services\VisitorStats;
use Kitoko\VisitorTracker\Services\VisitorTrackerService;

class VisitorStatsComposer
{
    public function compose(View $view)
    {
        $stats = App::get(VisitorTrackerService::class)->stats();
        $view->with('statsVisit', $stats);
    }
}