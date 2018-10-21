# Stream Remote Files

With this package you can stream remote contents right from your Laravel application.

## Installation

```
composer require titasgailius/laravel-stream-remote
```

## Usage

The `streamRemoteDownload` method may be used to generate a response that turns contents of a remote resource to a downloadable response without having to write anything to disk.

This method accepts a url, file name and an optional array of headers as it's arguments:

```php
return response()->streamRemoteDownload('https://example.com/remote/file.zip', 'archive.zip');
```

## Advanced

You may specify headers of the response, content-disposition value and chunk size of the streamed content:

```php
return response()->streamRemoteDownload('https://example.com/remote/file.zip', 'archive.zip', [
    'Content-Type' => 'application/zip'
], 'attachment', 1024);
```

This is a full signature of the `streamRemoteDownload` method:
```php
public function streamRemoteDownload(
    string $url,
    string $name = null,
    array $headers = [],
    string $disposition = 'attachment',
    int $chunk = 2048
): StreamedResponse;
```

## Tests

This package is covered with tests that are store in `tests` directory.
Run `./vendor/bin/phpunit` to run the test suite.
