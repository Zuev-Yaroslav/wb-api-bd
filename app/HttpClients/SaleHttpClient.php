<?php

namespace App\HttpClients;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class SaleHttpClient extends  HttpClient
{
    private  const ENDPOINT_INDEX = '/sales';

    public function index(array $queryParams) : Collection
    {
        $data = $this->http->get(self::ENDPOINT_INDEX, $queryParams)->collect();

        return $data;
    }
}
