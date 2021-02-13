<?php

namespace Nanuc\LaravelTrack\Models;

use Illuminate\Database\Eloquent\Model;

class ABTestOption extends Model
{
    protected $fillable = ['key', 'track_ab_test_id'];

    protected $table = 'track_ab_test_options';
}