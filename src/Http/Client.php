<?php

namespace Octopy\Debugify\Http;

use CurlHandle;
use Octopy\Debugify\Config;

class Client
{
    /**
     * @var CurlHandle|null
     */
    protected CurlHandle|null $curl = null;

    /**
     * @param  string $host
     * @param  int    $port
     */
    public function __construct(protected string $host, protected int $port)
    {
        //
    }

    /**
     * @param  Request $request
     * @return void
     */
    public function send(Request $request) : void
    {
        $handle = $this->handle('POST', '/');

        curl_setopt_array($handle, [
            CURLOPT_POSTFIELDS => json_encode($request->toArray([
                //
            ])),
        ]);

        curl_exec($handle);

        $error = null;
        if (curl_errno($handle)) {
            $error = curl_error($handle);
        }

        if ($error) {
            // for now, do nothing when there is an error
        }
    }

    /**
     * @param  string $method
     * @param  string $url
     * @return CurlHandle
     * @noinspection HttpUrlsUsage
     */
    protected function handle(string $method, string $url) : CurlHandle
    {
        if (! $this->curl) {
            $this->curl = curl_init();
        }

        $url = sprintf('http://%s:%d%s', $this->host, $this->port, $url);

        curl_reset($this->curl);

        curl_setopt_array($this->curl, [
            CURLOPT_URL            => $url,
            CURLOPT_TIMEOUT        => 2,
            CURLOPT_ENCODING       => '',
            CURLOPT_USERAGENT      => 'Debugify 1.0',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FAILONERROR    => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER     => array_merge([
                'Accept: application/json',
                'Content-Type: application/json',
            ]),
            CURLINFO_HEADER_OUT    => true,
        ]);

        if ($method === 'POST') {
            curl_setopt($this->curl, CURLOPT_POST, true);
        }

        return $this->curl;
    }
}