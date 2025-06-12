<?php

if (!function_exists('getTimeOfDay')) {
    function getTimeOfDay()
    {
        $hour = date('H');

        if ($hour < 12) {
            return 'Morning';
        } elseif ($hour < 17) {
            return 'Afternoon';
        } else {
            return 'Evening';
        }
    }
}



if (!function_exists('format_currency')) {
    function format_currency($amount, $currency = null)
    {
        if (!$currency) {
            $currency = config('app.currency', 'Rs ');
        }

        // Default symbol map
        $symbols = [
            'Rs' => 'Rs ',
        ];

        $symbol = $symbols[$currency] ?? $currency;
        $decimal_places = in_array($currency, ['JPY']) ? 0 : 2;

        return $symbol . number_format($amount, $decimal_places);
    }
}
