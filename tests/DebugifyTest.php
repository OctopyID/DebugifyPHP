<?php

namespace Octopy\Debugify\Tests;

use JetBrains\PhpStorm\NoReturn;
use Octopy\Debugify\Config;
use PHPUnit\Framework\TestCase;

class DebugifyTest extends TestCase
{
    /**
     * @return void
     */
    #[NoReturn]
    public function testConfigure() : void
    {
        dfy()->configure(function (\Octopy\Debugify\Config $config) {
            $config('foo.dev', 1234);
        });

        dd(new Config());
    }
}