<?php

namespace App\Console\Commands;

use App\HttpClients\StockHttpClient;
use App\Models\Stock;
use Illuminate\Console\Command;

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
        $stockHttpClient = StockHttpClient::make();
        $queryParams = [
            'dateFrom' => '2025-11-22',
            'dateTo' => '2025-11-22',
            'limit' => 3000,
        ];
        $data = $stockHttpClient->auth(config('wbapi.auth_key'))->index($queryParams);
//        dd($data['data']);
        $stocks = collect($data['data']);
        $stocks->each(function ($stock) {
            Stock::firstOrCreate($stock);
        });
    }
}
