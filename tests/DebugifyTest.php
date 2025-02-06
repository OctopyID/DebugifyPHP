<?php

namespace Octopy\Debugify\Tests;

use Octopy\Debugify\Config;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DebugifyTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function configure() : void
    {
        dfy()->configure(function (Config $config) {
            $config->port(1234);
        });
    }
}
