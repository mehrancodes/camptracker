<?php

namespace App\Basecamp;

use DOMDocument;

/**
 * Class Utilities.
 */
class Utilities
{
    /**
     * Get the time from webhook content.
     *
     * @param $content
     * @return string
     */
    public function getTime($content)
    {
        $dom = new DOMDocument;

        // Get the HTML content
        // We place an @ before the load method in order to SUPPRESS all WARNINGS.
        @$dom->loadHTML($content);

        $details = [];
        foreach ($dom->getElementsByTagName('div') as $tag) {
            $details[] = $tag->nodeValue;
        }

        // Here we have an array like ['some index', '#HOURS=5:30', '#NOTE hello there!', 'etc...']
        // We want to get the hours started by the #HOURS=<time> from the array.
        // Regex is valid for ["#HOURS 5:30", "#HOURS 05:30", "#HOURS=5:30", "#HOURS=05:30"]
        $time = preg_grep(
            '/#HOURS[=|\s]\d{1,2}:\d{2}/',
            $details
        );

        if (empty(current($time))) {
            return false;
        }

        // Skip if there wasn't anything matched.
        // Otherwise, get the time from the $time array variable
        preg_match(
            '/\d{1,2}:\d{2}/',
            current($time),
            $time
        );

        return secondsFromTime(current($time));
    }

    /**
     * Get the #NOTE from webhook content.
     *
     * @param $content
     * @return string
     */
    public function getDescription($content)
    {
        $dom = new DOMDocument;

        // Get the HTML content
        // We place an @ before the load method in order to SUPPRESS all WARNINGS.
        @$dom->loadHTML($content);

        $details = [];
        foreach ($dom->getElementsByTagName('div') as $tag) {
            $details[] = $tag->nodeValue;
        }

        $description = preg_grep('/#NOTE="(.*)"/', $details);

        if (empty(current($description))) {
            return;
        }

        preg_match(
            '/"(.*)"/',
            current($description),
            $description
        );

        // Truncate description to 150 characters to prevent db errors
        return substr(trim($description[1]), 0, 100).'...';
    }
}
