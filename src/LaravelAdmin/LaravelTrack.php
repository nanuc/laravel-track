<?php

namespace Nanuc\LaravelTrack\LaravelAdmin;

use Nanuc\LaravelAdmin\Modules\AdminModule;
use Nanuc\LaravelTrack\LaravelAdmin\Livewire\Dashboard;

class LaravelTrack extends AdminModule
{
    protected $icon = 'trending-up';
    protected $action = Dashboard::class;
    protected $caption = 'Track';
}