<?php

namespace Nanuc\LaravelTrack\Models;

use Illuminate\Database\Eloquent\Model;
use Nanuc\LaravelTrack\Facades\Tracker;
use Nanuc\LaravelTrack\Models\Traits\HasCustomConnection;

class PageView extends Model
{
    use HasCustomConnection;

    protected $table = 'track_page_views';

    public function goals()
    {
        return $this->belongsToMany(Goal::class, 'track_page_view_goal', 'track_page_view_id', 'track_goal_id');
    }

    public function setReachedGoals()
    {
        foreach(Tracker::getGoals() as $goal) {
            $this->goals()->attach($goal);
        }
    }
}