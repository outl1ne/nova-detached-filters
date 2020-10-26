<?php

namespace OptimistDigital\NovaDetachedFilters;

use Laravel\Nova\Card;

class NovaDetachedFilters extends Card
{
    public $width = '1/3'; // (full, 1/3, 1/2 etc..)
    protected $filters = [];
    protected $withReset = false;
    protected $withToggle = false;
    protected $persistFilters = false;
    protected $perPageOptions = null;

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

    public function withToggle(bool $value = true)
    {
        $this->withToggle = $value;
        return $this;
    }

    public function withPerPage($perPageOptions = null)
    {
        $this->perPageOptions = $perPageOptions;
        return $this;
    }

    private function getPerPageOptions()
    {
        if (is_callable($this->perPageOptions)) return call_user_func($this->perPageOptions);
        return is_array($this->perPageOptions) ? $this->perPageOptions : null;
    }

    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'withReset' => $this->withReset,
            'withToggle' => $this->withToggle,
            'persistFilters' => $this->persistFilters,
            'perPageOptions' => $this->getPerPageOptions(),
            'filters' => collect(is_callable($this->filters) ? $this->filters() : $this->filters)->each(function ($filter) {
                return $filter->jsonSerialize();
            }),
        ]);
    }
}
