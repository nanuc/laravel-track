<?php

namespace Nanuc\LaravelTrack\Models;

use Illuminate\Database\Eloquent\Model;
use Nanuc\LaravelTrack\Models\Traits\HasCustomConnection;

class Goal extends Model
{
    use HasCustomConnection;

    protected $table = 'track_goals';

    protected $fillable = ['key'];
}