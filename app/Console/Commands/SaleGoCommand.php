<?php

namespace App\Console\Commands;

use App\HttpClients\SaleHttpClient;
use App\Models\Income;
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
        $saleHttpClient = SaleHttpClient::make();
        $now = Carbon::now()->format('Y-m-d');
        $queryParams = [
            'dateFrom' => '2000-11-22',
            'dateTo' => $now,
            'limit' => 500,
        ];
        $data = $saleHttpClient->auth(config('wbapi.auth_key'))->index($queryParams);

        if (isset($data['data'])) {
            $sales = collect($data['data']);
            $sales->each(function ($sale) {
                Sale::firstOrCreate($sale);
            });
            return;
        }
        dump('Нет данных');
    }
}
