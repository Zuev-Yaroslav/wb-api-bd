<?php

namespace App\HttpClients;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class StockHttpClient extends  HttpClient
{
    private  const ENDPOINT_INDEX = '/stocks';

    public function index(array $queryParams) : Collection
    {
        $data = $this->http->get(self::ENDPOINT_INDEX, $queryParams)->collect();

        return $data;
    }
}
