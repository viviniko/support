<?php

use Illuminate\Support\Collection;

if (!function_exists('price_format')) {
    /**
     * Format price number.
     *
     * @param $price
     * @param null $decimals
     * @param null $decimalPoint
     * @param null $thousandsSep
     * @return string
     */
    function price_format($price, $decimals = null, $decimalPoint = null, $thousandsSep = null)
    {
        return number_format($price, $decimals ?: 2, $decimalPoint ?: '.', is_null($thousandsSep) ? ',' : $thousandsSep);
    }
}

if (!function_exists('build_tree')) {
    /**
     * Build tree.
     *
     * @param $collection
     * @param $parentId
     * @param $parentKey
     * @return Collection
     */
    function build_tree(Collection $collection, $parentId = null, $parentKey = 'parent_id')
    {
        $groupNodes = $collection->groupBy($parentKey);
        return $collection
            ->map(function($item) use ($groupNodes) {
                $item->setRelation('children', collect($groupNodes->get($item->id, [])));
                return $item;
            })->filter(function($item) use ($parentId, $parentKey) {
                return $item->{$parentKey} == $parentId;
            })->values();
    }
}