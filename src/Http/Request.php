<?php

namespace Octopy\Debugify\Http;

use Octopy\Debugify\Http\Payloads\Payload;

class Request
{
    /**
     * @param  string    $uuid
     * @param  Payload[] $data
     * @param  array     $meta
     */
    public function __construct(protected string $uuid, protected array $data = [], protected array $meta = [])
    {
        //
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        $payloads = [];

        foreach ($this->data as $payload) {
            $payloads[] = $payload->toArray();
        }

        return [
            'uuid' => $this->uuid,
            'meta' => $this->meta,
            'data' => $payloads,
            'time' => microtime(true),
        ];
    }
}