<?php

namespace Kitoko\VisitorTracker\Middleware;

use Closure;

use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Kitoko\VisitorTracker\Models\Visitor;
use Kitoko\VisitorTracker\Models\PageVisit;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        if (! Config::get('visitor-tracker.enabled')) {
            return $next($request);
        }

        $sessionId = $request->session()->getId();
        $agent = new Agent();

        $visitor = Visitor::firstOrCreate(
            ['session_id' => $sessionId],
            [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'browser' => $agent->browser(),
                'platform' => $agent->platform(),
                'user_id' => Auth::id(),
            ]
        );

        PageVisit::create([
            'visitor_id' => $visitor->id,
            'url' => $request->fullUrl(),
            'referer' => $request->headers->get('referer'),
            'visited_at' => Carbon::now(),
        ]);

        return $next($request);
    }
}
