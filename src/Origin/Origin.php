<?php

namespace Octopy\Debugify\Origin;

class Origin
{
# name: string;
# file: string;
# line: number;
# host: string;
    /**
     * @var string
     */
    protected string $name;

    /**
     * @param  string|null $file
     * @param  int|null    $line
     * @param  string      $host
     */
    public function __construct(protected string|null $file, protected int|null $line, protected string $host = '127.0.0.1')
    {
        $this->name = $this->file ? basename($this->file, '.php') : null;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return [
            'name' => $this->name,
            'file' => $this->file,
            'line' => $this->line,
            'host' => $this->host,
        ];
    }
}