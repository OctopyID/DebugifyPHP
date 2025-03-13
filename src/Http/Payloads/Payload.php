<?php

namespace Octopy\Debugify\Http\Payloads;

use Octopy\Debugify\Origin\OriginFactory;

abstract class Payload
{
    /**
     * @param $value
     */
    public function __construct(protected $value)
    {
        //
    }

    /**
     * @return string
     */
    protected function getType() : string
    {
        return 'custom';
    }

    /**
     * @return array {
     *     label: string,
     *     value: string,
     * }
     */
    protected abstract function getContent() : array;

    /**
     * @return array
     */
    protected function getOrigin() : array
    {
        return (new OriginFactory)->getOrigin()->toArray();
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return [
            'type'    => $this->getType(),
            'content' => $this->getContent(),
            'origin'  => $this->getOrigin(),
        ];
    }
}