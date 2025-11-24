<?php

namespace App\HttpClients;

use Illuminate\Database\Eloquent\Model;
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

    public function saveToDb(array $queryParams, string $model)
    {
        for ($i = 1; true; $i++) {
            $queryParams['page'] = $i;
            $data = $this->index($queryParams);
            sleep(2);
            if (isset($data['data'])) {
                $items = collect($data['data']);
                if ($items->isEmpty()) {
                    break;
                }
                $items->each(function ($item) use ($model) {
                    $model::create($item);
                });
                dump($model . ' ' . $i);
            } else {
                dump('Нет данных');
                break;
            }
        }

    }
}
