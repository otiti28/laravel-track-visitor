<?php

namespace Kitoko\VisitorTracker\Services;

use Kitoko\VisitorTracker\Models\Visitor;
use Carbon\Carbon;

class VisitorTrackerService
{

    public function stats(): array
        {
            return [
                'total'     => $this->total(),
                'today'     => $this->today(),
                'yesterday' => $this->yesterday(),
                'week'      => $this->week(),
                'month'     => $this->month(),
            ];
        }
    public function total()
    {
        // mets ici ta vraie logique
        return Visitor::count();
    }
    public function yesterday(){
        return Visitor::whereDate('created_at', Carbon::yesterday())->count();
    }

    public function today()
    {
        return Visitor::whereDate('created_at', Carbon::today())->count();
    }

    public function week()
    {
        return Visitor::whereBetween(
                        'created_at',
                        [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
                    )->count();
    }

    public function month(){
        return Visitor::whereMonth('created_at', Carbon::now()->month)->count();
    }
}
