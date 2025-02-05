<?php

use Octopy\Debugify\Debugify;

/**
 * @param ...$args
 * @return Debugify
 */
function dfy(...$args) : Debugify
{
    return (new Debugify)->send(...$args);
}