<?php

namespace Nanuc\LaravelTrack\Models\Traits;

trait HasCustomConnection
{
    public function getConnectionName()
    {
        return config('laravel-track.connection');
    }
}