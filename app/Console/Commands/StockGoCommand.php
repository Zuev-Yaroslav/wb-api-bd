<?php

namespace App\Console\Commands;

use App\HttpClients\StockHttpClient;
use App\Models\Stock;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class StockGoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:go';

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
        $stockHttpClient = StockHttpClient::make();
        $stockHttpClient->auth(config('wbapi.auth_key'));
        $queryParams = [
            'dateFrom' => $now,
            'dateTo' => $now,
            'limit' => 500,
        ];

        $stockHttpClient->saveToDb($queryParams, Stock::class);
    }
}
