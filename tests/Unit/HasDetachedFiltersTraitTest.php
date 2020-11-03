<?php

namespace OptimistDigital\NovaDetachedFilters\Tests\Unit;

use Laravel\Nova\Http\Requests\NovaRequest;
use OptimistDigital\NovaDetachedFilters\Tests\Fixtures\User;
use OptimistDigital\NovaDetachedFilters\Tests\Fixtures\UserResource;
use OptimistDigital\NovaDetachedFilters\Tests\TestCase;

class HasDetachedFiltersTraitTest extends TestCase
{
    public function test_detached_filters_are_available()
    {
        $user = new User;
        $resource = new UserResource($user);
        $request = NovaRequest::create('/');

        $this->assertCount(2, $resource->availableFilters($request));
    }
}
