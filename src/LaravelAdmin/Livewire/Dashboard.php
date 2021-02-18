<?php

namespace Nanuc\LaravelTrack\LaravelAdmin\Livewire;

use Nanuc\LaravelAdmin\Modules\ModuleComponent;
use Nanuc\LaravelTrack\Models\PageView;

class Dashboard extends ModuleComponent
{
    protected $title = 'Track';
    protected $view = 'track::dashboard';

    protected function getRenderParameters()
    {
        return [
            'todayPageViews' => PageView::where('created_at', '>', now()->startOfDay())->count(),
        ];
    }
}
