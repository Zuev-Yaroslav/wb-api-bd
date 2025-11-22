<?php

namespace App\HttpClients;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

abstract class HttpClient
{
    protected PendingRequest $http;
    private static array $instances = [];

    private static function getInstance(): self
    {
        if (!isset(self::$instances[static::class])) {
            self::$instances[static::class] = new static();
        }
        return self::$instances[static::class];
    }

    public static function make() : self
    {
        return static::getInstance();
    }

    public function auth(string $key) : self
    {
        $this->http->withQueryParameters(['key' => $key]);
        return $this;
    }

    public function __construct()
    {
        $this->http = Http::wbapi();
    }
}
