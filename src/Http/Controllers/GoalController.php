<?php

namespace Nanuc\LaravelTrack\Http\Controllers;

use Nanuc\LaravelTrack\Facades\Tracker;

class GoalController
{
    public function __invoke()
    {
        Tracker::goal(request()->goal);
    }
}
