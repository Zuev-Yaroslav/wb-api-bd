<?php

namespace App\HttpClients;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class IncomeHttpClient extends  HttpClient
{
    private  const ENDPOINT_INDEX = '/incomes';

    public function index(array $queryParams) : Collection
    {
        $data = $this->http->get(self::ENDPOINT_INDEX, $queryParams )->collect();

        return $data;
    }
}
