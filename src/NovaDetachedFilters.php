<?php

namespace OptimistDigital\NovaDetachedFilters;

use Laravel\Nova\Card;

class NovaDetachedFilters extends Card
{
    public $width = '1/3'; // (full, 1/3, 1/2 etc..)
    public $filters = [];
    protected $withReset = false;
    protected $withToggle = false;
    protected $persistFilters = false;
    protected $perPageOptions = null;
    protected $showPerPageInMenu = true;

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
        if (empty($width)) {
            return $this;
        }
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

    public function withPerPage($perPageOptions = null, $showInMenu = true)
    {
        $this->perPageOptions = $perPageOptions;
        $this->showPerPageInMenu = $showInMenu;

        return $this;
    }

    public function withToggle(bool $value = true)
    {
        $this->withToggle = $value;

        return $this;
    }

    public function getFlatFilters($filters = null)
    {
        $flatFilters = [];
        if (empty($filters)) {
            $filters = $this->getFilters();
        }

        collect($filters)->each(function ($filter) use (&$flatFilters) {
            if (property_exists($filter, 'filters')) {
                $childFilters = $this->getFlatFilters($filter->filters);
                $flatFilters = array_merge($childFilters, $flatFilters);

                return true;
            }

            return $flatFilters[] = $filter;
        });

        return $flatFilters;
    }

    public function getFilters()
    {
        return is_callable($this->filters) ? $this->filters() : $this->filters;
    }

    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'withReset' => $this->withReset,
            'withToggle' => $this->withToggle,
            'perPageOptions' => $this->getPerPageOptions(),
            'showPerPageInMenu' => $this->showPerPageInMenu,
            'persistFilters' => $this->persistFilters,
            'filters' => $this->serializeFilters(),
        ]);
    }

    private function getPerPageOptions()
    {
        if (is_callable($this->perPageOptions)) {
            return call_user_func($this->perPageOptions);
        }

        return is_array($this->perPageOptions) ? $this->perPageOptions : null;
    }

    private function serializeFilters()
    {
        return collect($this->getFilters())->map(function (&$filter) {
            return $filter->jsonSerialize();
        });
    }
}
