<?php

namespace TitasGailius\LaravelStreamRemote;

use GuzzleHttp\Client;
use Illuminate\Contracts\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StreamRemoteDownload
{
    /**
     * Response factory.
     *
     * @var \Illuminate\Contracts\Routing\ResponseFactory
     */
    protected $factory;

    /**
     * Http client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Instantiate a new handler isntance.
     *
     * @param \Illuminate\Contracts\Routing\ResponseFactory $factory
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(ResponseFactory $factory, Client $client)
    {
        $this->factory = $factory;
        $this->client = $client;
    }

    /**
     * Create a new streamed response.
     *
     * @param  string $url
     * @param  string|null $name
     * @param  array $headers
     * @param  string $disposition
     * @param  int $chunk
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function __invoke(string $url, string $name = null, array $headers = [], $disposition = 'attachment', int $chunk = 2048): StreamedResponse
    {
        return $this->factory->streamDownload(function () use ($url, $chunk) {
            $this->stream($url, $chunk);
        }, $name, $headers, $disposition);
    }

    /**
     * Stream contents of a given url.
     *
     * @param  string $url
     * @param  int $chunk
     * @return void
     */
    protected function stream(string $url, int $chunk)
    {
        $body = $this->client->get($url, ['stream' => true])->getBody();

        while (! $body->eof()) {
            echo $body->read($chunk);
        }
    }
}
