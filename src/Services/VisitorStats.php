<?php
namespace Kitoko\VisitorTracker\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Kitoko\VisitorTracker\Models\Visitor;
use Illuminate\Support\Facades\Config;

class VisitorStats
{
    public static function get()
    {
        return Cache::remember(
            'visitor_stats',
            Carbon::now()->addMinutes(Config::get('visitor-tracker.cache_minutes')),
            function () {

                return [
                    'today' => Visitor::whereDate('created_at', Carbon::today())->count(),
                    'yesterday' => Visitor::whereDate('created_at', Carbon::yesterday())->count(),
                    'week' => Visitor::whereBetween(
                        'created_at',
                        [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
                    )->count(),
                    'month' => Visitor::whereMonth('created_at', Carbon::now()->month)->count(),
                    'total' => Visitor::count(),
                    'highest' => Visitor::selectRaw('DATE(created_at) as date, COUNT(*) as visits')
                        ->groupBy('date')
                        ->orderByDesc('visits')
                        ->first(),
                ];
            }
        );
    }
}
