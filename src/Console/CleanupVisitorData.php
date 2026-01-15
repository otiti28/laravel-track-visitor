<?php
namespace Kitoko\VisitorTracker\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Kitoko\VisitorTracker\Models\Visitor;
use Kitoko\VisitorTracker\Models\PageVisit;


class CleanupVisitorData extends Command
{
    protected $signature = 'visitor-tracker:cleanup';
    protected $description = 'Cleanup old visitor tracking data';

    public function handle()
    {
        $days = Config::get('visitor-tracker.retention_days');
        $cutoff = Carbon::now()->subDays($days);

        PageVisit::where('visited_at', '<', $cutoff)->delete();
        Visitor::where('updated_at', '<', $cutoff)->delete();
    }
}
