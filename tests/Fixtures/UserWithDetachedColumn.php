<?php

namespace Outl1ne\NovaDetachedFilters\Tests\Fixtures;

use Illuminate\Http\Request;
use Outl1ne\NovaDetachedFilters\DetachedFilterColumn;
use Outl1ne\NovaDetachedFilters\NovaDetachedFilters;

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
