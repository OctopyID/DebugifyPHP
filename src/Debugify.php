<?php

namespace Octopy\Debugify;

use Closure;
use JetBrains\PhpStorm\ExpectedValues;
use JetBrains\PhpStorm\NoReturn;
use Octopy\Debugify\Http\Client;
use Octopy\Debugify\Http\Payloads\ColorPayload;
use Octopy\Debugify\Http\Payloads\Payload;
use Octopy\Debugify\Http\Payloads\SymfonyPayload;
use Octopy\Debugify\Http\Payloads\UnknownPayload;
use Octopy\Debugify\Http\Request;
use Octopy\Debugify\Support\PrimitiveType;
use Ramsey\Uuid\Uuid;

class Debugify
{
    /**
     * @var string
     */
    protected static string $uuid;

    /**
     * @var Config
     */
    protected static Config $conf;

    /**
     * @param  Config|null $conf
     */
    public function __construct(Config|null $conf = null)
    {
        static::$uuid = Uuid::uuid4();
        static::$conf = $conf ?? static::$conf ?? new Config([
            //
        ]);
    }

    /**
     * @param  Closure $callback
     * @return $this
     */
    public function configure(Closure $callback) : static
    {
        $callback(static::$conf);

        return $this;
    }

    /**
     * @param ...$args
     * @return $this
     */
    public function send(...$args) : Debugify
    {
        if (empty($args)) {
            return $this;
        }

        $payloads = [];
        foreach ($args as $arg) {
            $payloads[] = $this->payload($arg);
        }

        return $this->request($payloads);
    }

    /**
     * @param  string $color
     * @return $this
     */
    public function color(#[ExpectedValues(['green', 'blue', 'yellow', 'red'])] string $color) : Debugify
    {
        $colors = [
            'green'  => 's',
            'blue'   => 'i',
            'yellow' => 'w',
            'red'    => 'd',
        ];

        $color = strtolower($color);
        if (! isset($colors[$color])) {
            return $this;
        }

        return $this->request(new ColorPayload(
            $colors[$color],
        ));
    }

    /**
     * @param  string|int $status
     * @return void
     */
    #[NoReturn]
    public function die(string|int $status = 0) : void
    {
        die($status);
    }

    /**
     * @param  Payload|array $payloads
     * @return Debugify
     */
    private function request(Payload|array $payloads) : Debugify
    {
        if (! is_array($payloads)) {
            $payloads = [$payloads];
        }

        $request = new Request(static::$uuid, $payloads, [
            'version' => 'v1.0.0',
        ]);

        $client = new Client(
            host: static::$conf->host,
            port: static::$conf->port,
        );

        $client->send($request);

        return $this;
    }

    /**
     * @param  mixed $arg
     * @return Payload
     */
    private function payload(mixed $arg) : Payload
    {
        $type = gettype($arg);

        if ($type === 'object' || $type === 'array') {
            return new SymfonyPayload($arg);
        }

        return new UnknownPayload($arg);
    }
}