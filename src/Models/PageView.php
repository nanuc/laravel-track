<?php

namespace Nanuc\LaravelTrack\Models;

use Illuminate\Database\Eloquent\Model;
use Nanuc\LaravelTrack\Facades\Tracker;

class PageView extends Model
{
    protected $table = 'track_page_views';

    public function goals()
    {
        return $this->belongsToMany(Goal::class, 'track_page_view_goal', 'track_goal_id', 'track_page_view_id');
    }

    public function setReachedGoals()
    {
        foreach(Tracker::getGoals() as $goal) {
            $this->goals()->attach($goal);
        }
    }
}