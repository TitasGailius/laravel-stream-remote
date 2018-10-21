<?php

namespace TitasGailius\LaravelStreamRemote;

use GuzzleHttp\Client;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;

class StreamRemoteServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function boot()
    {
        ResponseFactory::macro('streamRemoteDownload', function (...$parameters) {
            return (new StreamRemoteDownload($this, new Client))(...$parameters);
        });
    }
}
