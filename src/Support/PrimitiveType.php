<?php

namespace Octopy\Debugify\Support;

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

class PrimitiveType
{
    /**
     * @param  mixed $value
     */
    public function __construct(protected mixed $value)
    {
        //
    }

    /**
     * @return string|int|bool|null
     */
    public function convert() : string|int|bool|null
    {
        $value = $this->value;

        if (is_null($value)) {
            return null;
        }

        if (is_string($value) || is_int($value) || is_float($value) || is_bool($value)) {
            return $value;
        }

        $cloner = new VarCloner;
        $dumper = new HtmlDumper;
        $cloned = $cloner->cloneVar($value);

        return
            VarDumperCleaner::handle($dumper->dump(
                $cloned, true,
            ));
    }
}