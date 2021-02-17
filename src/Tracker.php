<?php

namespace Nanuc\LaravelTrack;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Jenssegers\Agent\Agent;
use Nanuc\LaravelTrack\Models\ABTest;
use Nanuc\LaravelTrack\Models\ABTestOption;
use Nanuc\LaravelTrack\Models\Goal;
use Nanuc\LaravelTrack\Models\Visitor;

class Tracker
{
    protected const COOKIE_NAME = 'lt_session';
    protected const CACHE_PREFIX_AB_TESTS = 'tracker-ab-tests';

    protected $goals = [];
    protected $pageName;
    protected $pageView;
    protected $visitor;
    protected $nextOption;

    public function track()
    {
        $agent = new Agent();
        if($agent->isRobot()) {
            return;
        }

        $visitor = $this->getVisitor();

        $this->pageView = $visitor->trackPageView();
    }

    public function goal($goal)
    {
        $goal = Goal::firstOrCreate([
            'key' => $goal
        ]);

        if(in_array('track', Route::current()->computedMiddleware)) {
            $this->goals[] = $goal;
        }
        else {
            $this->getVisitor()
                ->pageViews()
                ->orderByDesc('id')
                ->first()
                ->goals()
                ->attach($goal);
        }
    }

    public function page($page)
    {
        $this->pageName = $page;
    }

    public function getGoals()
    {
        return $this->goals;
    }

    public function getPageName()
    {
        return $this->pageName;
    }

    public function nextOptionIs($testKey, $optionKey)
    {
        $test = ABTest::firstOrCreate(['key' => $testKey]);
        $option = ABTestOption::firstOrCreate([
            'track_ab_test_id' => $test->id,
            'key' => $optionKey
        ]);

        return $this->nextOption($test)->key == $option->key;
    }

    protected function nextOption(ABTest $test)
    {
        if($this->nextOption) {
            return $this->nextOption;
        }

        $agent = new Agent();
        if($agent->isRobot()) {
            return $test->options()->first();
        }

        $visitor = $this->getVisitor();
        $visitorOption = $visitor->abTests()->find($test->id);
        if($visitorOption) {
            $this->nextOption = ABTestOption::find($visitorOption->pivot->track_ab_test_option_id);
            return $this->nextOption;
        }

        if($currentOptionId = Cache::get(self::CACHE_PREFIX_AB_TESTS . $test->id)) {
            $options = $test->options->pluck('id')->toArray();
            $options[] = $test->options()->first()->id;

            $nextId = $options[array_search($currentOptionId, $options) + 1];
            $option = ABTestOption::find($nextId);
        }
        else {
            $option = $test->options()->first();
        }

        $visitor->abTests()->attach($test, [
            'track_ab_test_option_id' => $option->id
        ]);
        Cache::put(self::CACHE_PREFIX_AB_TESTS . $test->id, $option->id, now()->addMonth());
        $this->nextOption = $option;

        return $option;
    }

    protected function getVisitorKey()
    {
        return Cookie::get(self::COOKIE_NAME);
    }

    protected function getVisitor() : ?Visitor
    {
        if(!$this->visitor) {
            $this->visitor = Visitor::firstWhere('key', $this->getVisitorKey());
        }

        if(!$this->visitor) {
            $this->visitor = Visitor::create();
            Cookie::queue(self::COOKIE_NAME, $this->visitor->key, 5 * 365 * 24 * 60);
            $this->visitor->fillInfo();
        }

        return $this->visitor;
    }
}