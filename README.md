This package adds content marketing tracking and A/B tests to your app. The package tries to find a balance between privacy and useful data. All users will be anonymized, so by default there is no way to trace back a user.

Every user receives a random string which is stored in a cookie to identify them on the following visits.

## Installation
`composer require nanuc/laravel-track`

#### Run migrations
Run `php artisan migrate` to create the necessary tables.

#### Add middleware
To get started, register the tracking middleware in your HTTP kernel's $routeMiddleware array. Your application's HTTP kernel is typically located at `app/Http/Kernel.php`:

```php
protected $routeMiddleware = [
    // ...
    'track' => \Nanuc\LaravelTrack\Http\Middleware\TrackRequest::class,
];
```
Please don't use something different than `track` as the name as otherwise the package will not track correctly.

Once the middleware has been registered, you may attach it to any of your application's route definitions. All routes with this middleware will be tracked.

## Usage
### UTM
The package tracks the `utm_campaign` and `utm_source` query parameters. Nothing you need to do here.

### Goals
Set reached goals with `Tracker::goal('goalName');`. You don't need to define the goals - they will be created on the first use.

If the route where you attach a goal is not tracked (e.g. in Livewire routes) the goal will be attached to the last known page view for this visitor.

### Page name
As Laravel Livewire uses the same routes for different actions it might be useful to give a page a name. You can do this with `Tracker::page('pageName');`.

### A/B tests
Use the following syntax in your blade views:
```html
@ab('logo', 'blue')
    <img src="logo-blue"/>
@endab
@ab('logo', 'green')
    <img src="logo-green"/>
@endab
@ab('logo', 'red')
    <img src="logo-red"/>
@endab
```
You don't need to define the A/B tests' name and options - they will be created on the first use. Options will be rotated on each visit.