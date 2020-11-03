<?php

namespace OptimistDigital\NovaDetachedFilters;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Laravel\Nova\Http\Requests\NovaRequest;

trait HasDetachedFilters
{
    /**
     * Get the filters that are available for the given request.
     *
     * @param NovaRequest $request
     * @return Collection
     */
    public function availableFilters(NovaRequest $request)
    {
        return $this->resolveFilters($request)->filter->authorizedToSee($request)->values();
    }

    /**
     * Get the filters for the given request.
     *
     * @param NovaRequest $request
     * @return Collection
     */
    public function resolveFilters(NovaRequest $request)
    {
        $menuFilters = self::modifyFilters(parent::resolveFilters($request), true);
        $detachedFilters = self::modifyFilters(self::resolveDetachedFilters($request), false);

        return $menuFilters->merge($detachedFilters)->unique('class');
    }

    /**
     * Get the filters available on the entity.
     *
     * @param Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get detached filters for the given request.
     *
     * @param NovaRequest $request
     * @return Collection
     */
    private function resolveDetachedFilters(NovaRequest $request)
    {
        $detachedFilterCards = collect($this->cards($request))->whereInstanceOf(NovaDetachedFilters::class);
        $detachedFilters = [];

        $detachedFilterCards->map(function ($card) use (&$detachedFilters) {
            $detachedFilters = array_merge($detachedFilters, $card->getFlatFilters());
        });

        return collect($detachedFilters);
    }

    public static function modifyFilters(Collection $filters, bool $showInMenu)
    {
        $filters->map(function (&$filter) use ($showInMenu) {
            $filter->withMeta(['showInMenu' => $showInMenu]);
            $filter->class = get_class($filter);

            return $filter;
        });

        return $filters;
    }
}
