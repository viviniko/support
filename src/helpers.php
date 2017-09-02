<?php

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