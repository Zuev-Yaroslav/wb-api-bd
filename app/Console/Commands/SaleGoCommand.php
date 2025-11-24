<?php

namespace App\Console\Commands;

use App\HttpClients\SaleHttpClient;
use App\Models\Sale;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SaleGoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sale:go';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now()->format('Y-m-d');
        $saleHttpClient = SaleHttpClient::make();
        $saleHttpClient->auth(config('wbapi.auth_key'));
        $queryParams = [
            'dateFrom' => '2000-01-01',
            'dateTo' => $now,
            'limit' => 500,
        ];

        $saleHttpClient->saveToDb($queryParams, Sale::class);
    }
}
