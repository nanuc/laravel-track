<?php

namespace Nanuc\LaravelTrack\Models;

use Illuminate\Database\Eloquent\Model;
use Nanuc\LaravelTrack\Models\Traits\HasCustomConnection;

class ABTestOption extends Model
{
    use HasCustomConnection;

    protected $fillable = ['key', 'track_ab_test_id'];

    protected $table = 'track_ab_test_options';
}