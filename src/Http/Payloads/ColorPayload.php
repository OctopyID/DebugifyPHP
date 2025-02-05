<?php

namespace Octopy\Debugify\Http\Payloads;

class ColorPayload extends Payload
{
    /**
     * @return string
     */
    protected function getType() : string
    {
        return 'color';
    }

    /**
     * @inheritDoc
     */
    protected function getContent() : array
    {
        return [
            'label' => 'color',
            'value' => $this->value,
        ];
    }
}