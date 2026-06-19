<?php

if (!function_exists('currency')) {

    function currency()
    {
        return session('currency', config('currency.default', 'GBP'));
    }
}

if (!function_exists('currency_symbol')) {

    function currency_symbol()
    {
        $currency = currency();

        return config('currency.currencies')[$currency]['symbol'] ?? '£';
    }
}

if (!function_exists('convert_price')) {

    function convert_price($price)
    {
        $currency = currency();

        $rate = config('currency.currencies')[$currency]['rate'] ?? 1;

        // GBP is BASE → no conversion needed
        if ($currency === 'GBP') {
            return (float) $price;
        }

        return (float) $price * (float) $rate;
    }
}

if (!function_exists('format_price')) {

    function format_price($price)
    {
        return number_format(convert_price($price), 2);
    }
}