This package adds content marketing tracking and A/B tests to your app. The package tries to find a balance between privacy and useful data. All users will be anonymized, so by default there is no way to trace back a user.

Every user receives a random string which is stored in a cookie to identify them on the following visits.

## Installation
`composer require nanuc/laravel-track`

#### Publish config (optional)
`php artisan vendor:publish --provider="Nanuc\LaravelTrack\LaravelTrackServiceProvider" --tag=config`

You can configure a separate database connection.

#### Run migrations
Run `php artisan migrate` to create the necessary tables.


## Usage
### Middleware
Just add the middleware `track` to the routes you want to track.

### UTM
The package tracks the `utm_campaign` and `utm_source` query parameters. Nothing you need to do here.

### Goals
Set reached goals with `Tracker::goal('goalName');`. You don't need to define the goals - they will be created on the first use.

If the route where you attach a goal is not tracked (e.g. in Livewire routes) the goal will be attached to the last known page view for this visitor.

#### Goals in views
You can set goals in views too. They will be reached when the place where the component was placed gets visible in the view port. This can be used e.g. to measure if an A/B tested heroshot gets scrolls further down the page.

Just use `<track::goal goal="goalName" />` in your blade view. For this to work you need to have a stack `scripts` in your layout - the name can be configured (`laravel-track.goals.component.stack-name`).

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

## Dashboard
This package offers a module for [LaravelAdmin](https://github.com/laravel-admin). To use it make sure to install LaravelAdmin first. Afterwards add `\Nanuc\LaravelTrack\LaravelAdmin\LaravelAdmin::class` to `config/laravel-admin`:
```
'modules' => [
    ...
    \Nanuc\LaravelTrack\LaravelAdmin\LaravelAdmin::class,
]
```