<?php

namespace Tests;

use BadMethodCallException;
use PHPUnit\Framework\TestCase;
use Illuminate\Routing\ResponseFactory;
use TitasGailius\LaravelStreamRemote\StreamRemoteServiceProvider;

class StreamRemoteServiceProviderTest extends TestCase
{
    /** @test */
    public function it_registers_response_factory_macro()
    {
        $provider = new StreamRemoteServiceProvider(null);

        $this->assertFalse(ResponseFactory::hasMacro('streamRemoteDownload'));

        $provider->boot();

        $this->assertTrue(ResponseFactory::hasMacro('streamRemoteDownload'));
    }
}
