<?php

namespace Octopy\Debugify\Http\Payloads;

use Octopy\Debugify\Support\PrimitiveType;

/**
 * symfony/var-dumper
 * @property PrimitiveType $value
 */
class SymfonyPayload extends Payload
{
    /**
     * @return string
     */
    protected function getType() : string
    {
        return 'symfony';
    }

    /**
     * @inheritDoc
     */
    protected function getContent() : array
    {
        return [
            'label' => 'HTML',
            'value' => $this->value->convert(),
        ];
    }
}