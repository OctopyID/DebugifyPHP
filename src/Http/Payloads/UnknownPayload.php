<?php

namespace Octopy\Debugify\Http\Payloads;

class UnknownPayload extends Payload
{
    /**
     * @inheritDoc
     */
    protected function getContent() : array
    {
        $value = $this->value;

        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }

        if (is_null($value)) {
            $value = 'null';
        }

        return [
            'label' => 'String',
            'value' => (string) $value,
        ];
    }
}