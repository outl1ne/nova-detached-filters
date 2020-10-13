<?php

namespace OptimistDigital\NovaDetachedFilters;

use Illuminate\Contracts\Routing\UrlRoutable;
use Laravel\Nova\Card;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\ResolvesFilters;

class NovaDetachedFilters extends Card
{
    public $width = '1/3'; // (full, 1/3, 1/2 etc..)
    protected $filters = [];
    protected $withReset = false;
    protected $persistFilters = false;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function component()
    {
        return 'nova-detached-filters';
    }

    public function width($width)
    {
        if (empty($width)) return $this;
        $this->width = $width;
        return $this;
    }

    public function withReset(bool $value = true)
    {
        $this->withReset = $value;
        return $this;
    }

    public function persistFilters(bool $value = true)
    {
        $this->persistFilters = $value;
        return $this;
    }

    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'withReset' => $this->withReset,
            'persistFilters' => $this->persistFilters,
            'filters' => collect(is_callable($this->filters) ? $this->filters() : $this->filters)->each(function ($filter) {
                return $filter->jsonSerialize();
            }),
        ]);
    }
}
