<?php

declare(strict_types = 1);

namespace Octopy\Debugify;

/**
 * @property string  $host
 * @property integer $port
 */
class Config
{
    /**
     * @var array
     */
    protected array $data = [
        'host' => '127.0.0.1',
        'port' => 1945,
    ];

    /**
     * @param  string $name
     * @param  mixed  $value
     * @return void
     */
    public function __set(string $name, mixed $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @param  string $name
     * @return mixed
     */
    public function __get(string $name) : mixed
    {
        return $this->data[$name];
    }

    /**
     * @param  string $host
     * @param  int    $port
     * @return $this
     */
    public function __invoke(string $host, int $port) : self
    {
        return $this->host($host)->port($port);
    }

    /**
     * @param  string $host
     * @return $this
     */
    public function host(string $host) : self
    {
        $this->data['host'] = $host;

        return $this;
    }

    /**
     * @param  int $port
     * @return $this
     */
    public function port(int $port) : self
    {
        $this->data['port'] = $port;

        return $this;
    }
}