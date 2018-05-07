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
        return !is_numeric($price) ? $price : number_format($price, $decimals ?: 2, $decimalPoint ?: '.', is_null($thousandsSep) ? ',' : $thousandsSep);
    }
}

if (! function_exists('theme_asset')) {
    /**
     * Generate an theme asset path for the application.
     *
     * @param  string  $path
     * @param  bool    $secure
     * @return string
     */
    function theme_asset($path, $secure = null) {
        return app('theme')->getAssetUrl($path, $secure);
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

if (!function_exists('flatten_tree')) {
    /**
     * Build tree.
     *
     * @param $tree
     * @param $column
     * @param $key
     * @param $depth
     * @return array
     */
    function flatten_tree(Collection $tree, $column = 'name', $key = 'id', $depth = 0) {
        $items = [];
        // $icons = ['├', '└', '│', '─'];
        $space = '──';

        // $count = count($tree);
        foreach ($tree as $index => $node) {
            $items[$node->{$key}] = str_repeat($space, $depth) . $node->{$column};
            if (!empty($node->children)) {
                $items += flatten_tree($node->children, $column, $key, $depth + 1);
            }
        }

        return $items;
    }
}