<?php

namespace OptimistDigital\NovaDetachedFilters;

use Laravel\Nova\Card;

class NovaDetachedFilters extends Card
{
    public $width = '1/3'; // (1/3, 1/2, or full)
    public $filters = [];

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function component()
    {
        return 'nova-detached-filters';
    }

    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'filters' => collect(is_callable($this->filters) ? $this->filters() : $this->filters)->each(function ($filter) {
                return $filter->jsonSerialize();
            }),
        ]);
    }
}
