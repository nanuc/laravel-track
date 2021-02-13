<?php

namespace Nanuc\LaravelTrack\Http\Middleware;

use Nanuc\LaravelTrack\Facades\Tracker;

class TrackRequest
{
    public function handle($request, $next)
    {
        Tracker::track();

        return $next($request);
    }
}
