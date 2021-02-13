<?php

namespace Nanuc\LaravelTrack\Facades;

use Illuminate\Support\Facades\Facade;

class Tracker extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'track';
    }
}