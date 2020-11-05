<?php

namespace OptimistDigital\NovaDetachedFilters\Tests\Fixtures;

use Illuminate\Http\Request;
use OptimistDigital\NovaDetachedFilters\DetachedFilterColumn;
use OptimistDigital\NovaDetachedFilters\NovaDetachedFilters;

class UserWithDetachedColumn extends UserResource
{
    public function cards(Request $request)
    {
        return [
            NovaDetachedFilters::make([
                FirstFilter::make(),
                DetachedFilterColumn::make([
                    ThirdFilter::make(),
                ]),
            ]),
        ];
    }
}
