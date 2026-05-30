<?php

if (!function_exists('currency')) {

    function currency()
    {
        return session('currency', config('currency.default'));
    }
}

if (!function_exists('currency_symbol')) {

    function currency_symbol()
    {
        return config('currency.currencies')[currency()]['symbol'];
    }
}

if (!function_exists('convert_price')) {

    function convert_price($price)
    {
        $rate = config('currency.currencies')[currency()]['rate'];

        return number_format($price * $rate, 2);
    }
}