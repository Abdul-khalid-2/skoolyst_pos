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
