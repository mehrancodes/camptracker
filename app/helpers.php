<?php

use Illuminate\Support\Facades\Request;

if (! function_exists('timeFromSeconds')) {
    function timeFromSeconds($seconds)
    {
        $h = floor($seconds / 3600);
        $m = floor(($seconds % 3600) / 60);

        return sprintf('%02d:%02d', $h, $m);
    }
}

if (! function_exists('secondsFromTime')) {
    function secondsFromTime($time)
    {
        list($h, $m) = explode(':', $time);

        return ($h * 3600) + ($m * 60);
    }
}

if (! function_exists('setActiveLink')) {
    function setActiveLink($path)
    {
        return Request::url() == $path ? 'bg-blue-100' : '';
    }
}
