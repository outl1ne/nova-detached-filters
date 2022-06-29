<?php

namespace Outl1ne\NovaDetachedFilters\Tests\Feature;

use Outl1ne\NovaDetachedFilters\NovaDetachedFilters;
use Outl1ne\NovaDetachedFilters\Tests\Fixtures\FirstFilter;
use Outl1ne\NovaDetachedFilters\Tests\Fixtures\SecondFilter;
use Outl1ne\NovaDetachedFilters\Tests\Fixtures\ThirdFilter;
use Outl1ne\NovaDetachedFilters\Tests\Fixtures\User;
use Outl1ne\NovaDetachedFilters\Tests\Fixtures\UserResource;
use Outl1ne\NovaDetachedFilters\Tests\TestCase;

class DetachedFiltersTest extends TestCase
{
    public function test_the_card_can_serialize_filters()
    {
        $testFilters = collect([
            (new FirstFilter())->jsonSerialize(),
            (new SecondFilter())->jsonSerialize(),
            (new ThirdFilter())->jsonSerialize(),
        ]);

        $card = NovaDetachedFilters::make([
            FirstFilter::make(),
            SecondFilter::make(),
            ThirdFilter::make(),
        ]);

        $this->assertEquals($testFilters, $card->jsonSerialize()['filters']);
    }

    public function test_the_card_can_have_resource_per_page_option()
    {
        $user = new User;
        $resource = new UserResource($user);
        $card = NovaDetachedFilters::make([])->withPerPage($resource::perPageOptions());

        $this->assertEquals(['25', '50', '100'], $card->jsonSerialize()['perPageOptions']);
    }
}
