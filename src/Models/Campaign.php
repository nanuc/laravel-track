<?php

namespace Nanuc\LaravelTrack\Models;

use Illuminate\Database\Eloquent\Model;
use Nanuc\LaravelTrack\Models\Traits\HasCustomConnection;

class Campaign extends Model
{
    use HasCustomConnection;

    protected $table = 'track_campaigns';

    public static function fromRequest()
    {
        if(request()->has('utm_campaign')) {
            $campaignKey = request()->get('utm_campaign');

            return self::firstOrCreate([
                'key' => $campaignKey
            ]);
        }
    }
}