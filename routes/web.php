<?php

Route::group(['middleware' => ['web']], function () {
    Route::post(config('laravel-track.goals.component.route'), \Nanuc\LaravelTrack\Http\Controllers\GoalController::class);
});
