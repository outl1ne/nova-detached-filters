<?php

namespace OptimistDigital\NovaDetachedFilters;

use JsonSerializable;

class DetachedFilterColumn implements JsonSerializable
{
    protected $filters = [];
    protected $width = 'w-auto';
    protected $name = 'detached-filter-column';

    public function __construct($filters, $width = 'w-auto')
    {
        $this->filters = $filters;
        $this->width = $width;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'width' => $this->width,
            'name' => $this->name,
            'filters' => collect(is_callable($this->filters) ? $this->filters() : $this->filters)->each(function ($filter) {
                return $filter->jsonSerialize();
            }),
        ];
    }
}
