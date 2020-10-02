<?php

namespace OptimistDigital\NovaDetachedFilters;

use Laravel\Nova\Card;

class NovaDetachedFilters extends Card
{
    public $width = '1/3'; // (full, 1/3, 1/2 etc..)
    protected array $filters = [];
    protected bool $withReset = false;
    protected bool $persistFilters = false;

    public function __construct($filters = [])
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
