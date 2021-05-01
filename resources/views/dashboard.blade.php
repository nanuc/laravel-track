<div>
    <x-helpers::tabs active="Page views">
        <x-helpers::tab name="Page views">
            Page views today: {{ $todayPageViews }}
        </x-helpers::tab>

        <x-helpers::tab name="Success measurement">
            <livewire:track.success-measurement />
        </x-helpers::tab>
    </x-helpers::tabs>

</div>