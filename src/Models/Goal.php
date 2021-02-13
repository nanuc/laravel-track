<?php

namespace Nanuc\LaravelTrack\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $table = 'track_goals';

    protected $fillable = ['key'];
}