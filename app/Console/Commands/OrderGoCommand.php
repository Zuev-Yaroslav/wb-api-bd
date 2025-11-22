<?php

namespace App\Console\Commands;

use App\HttpClients\OrderHttpClient;
use App\Models\Order;
use Illuminate\Console\Command;

class OrderGoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:go';

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
        $orderHttpClient = OrderHttpClient::make();
        $queryParams = [
            'dateFrom' => '2000-11-22',
            'dateTo' => '2025-11-22',
            'limit' => 10,
            'page' => 2,
        ];
        $data = $orderHttpClient->auth(config('wbapi.auth_key'))->index($queryParams);
        $orders = collect($data['data']);
        $orders->each(function ($order) {
            Order::firstOrCreate($order);
        });
    }
}
