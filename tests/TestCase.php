<?php

namespace Outl1ne\NovaDetachedFilters\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * Assert a top-level subset for an array.
     *
     * @param array $subset
     * @param array $array
     * @return void
     */
    public function assertSubset($subset, $array)
    {
        $values = collect($array)->only(array_keys($subset))->all();

        $this->assertEquals($subset, $values, 'The expected subset does not match the given array.');
    }
}
