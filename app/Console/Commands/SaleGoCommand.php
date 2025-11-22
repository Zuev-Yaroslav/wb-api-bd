<?php

namespace App\Console\Commands;

use App\HttpClients\SaleHttpClient;
use App\Models\Sale;
use Illuminate\Console\Command;

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
        $queryParams = [
            'dateFrom' => '2000-11-22',
            'dateTo' => '2025-11-22',
            'limit' => 3000,
        ];
        $data = $saleHttpClient->auth(config('wbapi.auth_key'))->index($queryParams);
//        dd($data['data']);
        $sales = collect($data['data']);
        $sales->each(function ($sale) {
            Sale::firstOrCreate($sale);
        });
    }
}
