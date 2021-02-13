<?php

namespace Nanuc\LaravelTrack\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
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