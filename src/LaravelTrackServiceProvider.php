<?php

namespace Nanuc\LaravelTrack;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Nanuc\LaravelTrack\Http\Middleware\TrackRequest;

class LaravelTrackServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        Blade::directive('ab', function($expression) {
            $temp = collect(explode(',', $expression))->map(function ($item) {
                return str_replace(["'", '"'], '',trim($item));
            });

            return '<?php if(Tracker::nextOptionIs("' . $temp[0] . '", "' . $temp[1] . '")) { ?>';
        });
        Blade::directive('endab', function($expression) {
            return '<?php } ?>';
        });
    }

    public function register()
    {
        $this->app->singleton('track', fn() => new Tracker());
        app('router')->aliasMiddleware('track', TrackRequest::class);
    }
}