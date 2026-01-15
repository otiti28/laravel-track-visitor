<?php
namespace Kitoko\VisitorTracker\ViewComposers;

use Illuminate\View\View;
use Kitoko\VisitorTracker\Services\VisitorStats;

class VisitorStatsComposer
{
    public function compose(View $view)
    {
        $view->with('statsVisit', VisitorStats::get());
    }
}