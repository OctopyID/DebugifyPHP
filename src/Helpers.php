<?php

use JetBrains\PhpStorm\NoReturn;
use Octopy\Debugify\Debugify;

if (! function_exists('dfy')) {
    /**
     * @param ...$args
     * @return Debugify
     */
    function dfy(...$args) : Debugify
    {
        return (new Debugify)->send(...$args);
    }
}
if (! function_exists('dfyd')) {
    /**
     * @param ...$args
     * @return void
     */
    #[NoReturn]
    function dfyd(...$args) : void
    {
        dfy(...$args)->die();
    }
}