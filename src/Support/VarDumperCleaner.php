<?php

namespace Octopy\Debugify\Support;

use DOMDocument;
use DOMXPath;

class VarDumperCleaner
{
    /**
     * Remove the <script> and <style> tags because both are already provided
     * in the Client and also to reduce the size of the payload sent.
     *
     * @param  string $html
     * @return string
     */
    public static function handle(string $html) : string
    {
        $dom = new DOMDocument;
        @$dom->loadHTML($html);

        $xpath = new DOMXPath($dom);
        $element = $xpath->query("//pre[starts-with(@id, 'sf-dump-')]");

        if ($element->length > 0) {
            return $dom->saveHTML($element->item(0));
        }

        return $html;
    }
}