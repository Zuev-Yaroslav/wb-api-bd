<?php

namespace App\Console\Commands;

use App\HttpClients\StockHttpClient;
use App\Models\Sale;
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
        $stockHttpClient = StockHttpClient::make();
        $now = Carbon::now()->format('Y-m-d');
        $queryParams = [
            'dateFrom' => $now,
            'dateTo' => $now,
            'limit' => 500,
        ];
        $data = $stockHttpClient->auth(config('wbapi.auth_key'))->index($queryParams);
        if (isset($data['data'])) {
            $stocks = collect($data['data']);
            $stocks->each(function ($stock) {
                Stock::firstOrCreate($stock);
            });
            return;
        }
        dump('Нет данных');
    }
}
