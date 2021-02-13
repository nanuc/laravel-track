<?php

namespace Nanuc\LaravelTrack\Models;

use Illuminate\Database\Eloquent\Model;

class ABTest extends Model
{
    protected $fillable = ['key'];

    protected $table = 'track_ab_tests';

    public function options()
    {
        return $this->hasMany(ABTestOption::class, 'track_ab_test_id');
    }
}