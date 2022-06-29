<?php

namespace Outl1ne\NovaDetachedFilters;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;

class CardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-detached-filters', __DIR__ . '/../dist/js/entry.js');
            Nova::style('nova-detached-filters-css', __DIR__ . '/../dist/css/entry.css');
        });
    }
}
