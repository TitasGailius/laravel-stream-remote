<?php

namespace Tests;

use Mockery;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Illuminate\Contracts\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;
use TitasGailius\LaravelStreamRemote\StreamRemoteDownload;

class StreamRemoteDownloadTest extends TestCase
{
    /**
     * This method is called after each test.
     */
    protected function tearDown()
    {
        Mockery::close();
    }

    /** @test */
    public function it_creates_a_streamed_response_with_guzzle_streaming_remote_file()
    {
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('get')
            ->once()
            ->with('https://example.com/foo.zip', ['stream' => true])
            ->andReturn(new Response(200));

        $factory = Mockery::mock(ResponseFactory::class);
        $factory->shouldReceive('streamDownload')
            ->once()
            ->with(Mockery::any(), 'foo.zip', ['content-type' => 'application/zip'], 'attachment')
            ->andReturnUsing(function ($callback) { $callback(); return new StreamedResponse; });

        $handler = new StreamRemoteDownload($factory, $client);
        $response = $handler('https://example.com/foo.zip', 'foo.zip', ['content-type' => 'application/zip']);

        $this->assertInstanceOf(StreamedResponse::class, $response);
    }
}
