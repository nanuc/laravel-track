<div class="laravel-track-goal" data-value="{{ $goal }}"></div>
@once
    @push(config('laravel-track.goals.component.stack-name'))
        <script>
            var laravelTrackReachedGoals = [];
            window.addEventListener('DOMContentLoaded', (event) => {
                const elementsToTrack = document.querySelectorAll('.laravel-track-goal');

                let observer = new IntersectionObserver(entries => {
                    entries.forEach(observerEntry => {
                        if(observerEntry.isIntersecting) {
                            let goal = observerEntry.target.dataset.value;
                            if(!laravelTrackReachedGoals.includes(goal)) {
                                laravelTrackReachedGoals.push(goal);
                                var xhttp = new XMLHttpRequest();
                                xhttp.open('POST', '{{ config('laravel-track.goals.component.route') }}', true);
                                xhttp.setRequestHeader("Content-Type", "application/json");
                                xhttp.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                                xhttp.send(JSON.stringify({goal: goal}));
                            }
                        }
                    });
                });

                elementsToTrack.forEach(element => {
                    observer.observe(element);
                });
            });
        </script>
    @endpush
@endonce