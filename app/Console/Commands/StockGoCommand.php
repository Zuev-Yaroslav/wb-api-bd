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
        for ($i = 1; true; $i++) {
            $queryParams = [
                'dateFrom' => '2000-01-01',
                'dateTo' => $now,
                'limit' => 500,
                'page' => $i,
            ];

            $data = $stockHttpClient->index($queryParams);
            sleep(2);
            if (isset($data['data'])) {
                $stocks = collect($data['data']);
                if ($stocks->isEmpty()) {
                    break;
                }
                $stocks->each(function ($stock) {
                    Stock::create($stock);
                });
                dump($i);
            } else {
                dump('Нет данных');
                break;
            }
        }
    }
}
