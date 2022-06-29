<?php

namespace Outl1ne\NovaDetachedFilters\Tests\Fixtures;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class SecondFilter extends Filter
{
    public function apply(Request $request, $query, $value)
    {
        return $query;
    }

    public function options(Request $request)
    {
        return [];
    }
}
