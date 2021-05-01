<?php

namespace Nanuc\LaravelTrack\LaravelAdmin\Livewire;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Nanuc\LaravelTrack\Models\ABTest;
use Nanuc\LaravelTrack\Models\Campaign;
use Nanuc\LaravelTrack\Models\Goal;
use Nanuc\LaravelTrack\Models\PageView;
use Nanuc\LaravelTrack\Models\Visitor;

class SuccessMeasurement extends Component
{
    public $filterABTests = false;
    public $filterCampaigns = false;

    public $abTests = [];
    public $abTestOptions = [];
    public $campaigns = [];

    public function mount()
    {
        $this->selectAllABTests();
        $this->selectAllCampaigns();
    }

    public function render()
    {
        return view('track::success-measurement', [
            'allCampaigns' => Campaign::all(),
            'allABTests' => ABTest::with('options')->get(),
            'stats' => $this->getStats(),
        ]);
    }

    public function selectAllABTests()
    {
        $this->abTests = ABTest::all()->mapWithKeys(fn($abTest) => [$abTest->id => true]);
    }

    public function selectAllCampaigns()
    {
        $this->campaigns = Campaign::all()->mapWithKeys(fn($campaign) => [$campaign->id => true]);
    }

    public function getStats()
    {
        $visitorQuery = Visitor::query();

        if($this->filterCampaigns) {
            $visitorIds = PageView::whereIn('track_campaign_id', $this->getSelectedIds($this->campaigns))
                ->pluck('id');
            $visitorQuery = $visitorQuery->whereIn('id', $visitorIds);
        }

        if($this->filterABTests) {
            $abTestOptionIds = collect();
            foreach($this->getSelectedIds($this->abTests) as $abTestId) {
                $abTestOptionIds = $abTestOptionIds->concat($this->getSelectedIds(Arr::get($this->abTestOptions, $abTestId)));
            }
            $visitorIds = DB::connection(config('laravel-track.connection'))
                ->table('track_visitor_ab_test_option')
                ->whereIn('track_ab_test_option_id', $abTestOptionIds)
                ->pluck('id');

            $visitorQuery = $visitorQuery->whereIn('id', $visitorIds);
        }

        $visitorIds = $visitorQuery->pluck('id');

        $goalQuotes = DB::connection(config('laravel-track.connection'))
            ->table('track_page_view_goal')
            ->select('track_goal_id', DB::raw('count(*) as total'))
            ->groupBy('track_goal_id')
            ->whereIn('track_visitor_id', $visitorIds)
            ->get();

        $goals = Goal::all()->mapWithKeys(fn($goal) => [$goal->id => $goal]);

        return [
            'visitors' => count($visitorIds),
            'goals' => $goalQuotes->map(fn($goalQuote) => [
                'goal' => $goals[$goalQuote->track_goal_id],
                'total' => $goalQuote->total,
            ])
        ];
    }

    protected function getSelectedIds($array)
    {
        return collect($array)->filter(fn($item) => $item)->keys();
    }
}
