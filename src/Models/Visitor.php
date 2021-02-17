<?php

namespace Nanuc\LaravelTrack\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Nanuc\LaravelTrack\Facades\Tracker;
use Nanuc\LaravelTrack\Models\Traits\HasCustomConnection;

class Visitor extends Model
{
    use HasCustomConnection;

    protected $table = 'track_visitors';

    public static function booted()
    {
        static::creating(function ($model) {
            $model->key = Str::random(200);
        });
    }

    public function pageViews()
    {
        return $this->hasMany(PageView::class,'track_visitor_id');
    }

    public function abTests()
    {
        return $this->belongsToMany(ABTest::class, 'track_visitor_ab_test_option', 'track_visitor_id', 'track_ab_test_id')
            ->withPivot('track_ab_test_option_id');
    }

    public function trackPageView()
    {
        $pageView = PageView::forceCreate([
            'track_visitor_id' => $this->id,
            'page_name' => Tracker::getPageName(),
            'route' => Route::currentRouteName(),
            'method' => request()->method(),
            'url' => url()->current(),
            'track_campaign_id' => Campaign::fromRequest()?->id,
            'campaign_source' => $this->getReferer()
        ]);

        $pageView->setReachedGoals();

        return $pageView;
    }

    protected function getReferer()
    {
        if(request()->has('utm_source')) {
            return request()->get('utm_source');
        }

        return request()->headers->get('referer');
    }

    public function fillInfo()
    {
        app()->terminating(function() {
            $agent = new Agent();
            $geo = geoip(request()->ip());

            $this->update([
                'device_type' => $agent->deviceType(),
                'device' => $agent->device(),
                'platform' => $platform = $agent->platform(),
                'platform_version' => $agent->version($platform),
                'browser' => $browser = $agent->browser(),
                'browser_version' => $agent->version($browser),
                'country' => $geo->country,
                'city' => $geo->city,
            ]);

        });
    }
}