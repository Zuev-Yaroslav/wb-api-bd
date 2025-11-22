<?php

namespace App\Console\Commands;

use App\HttpClients\OrderHttpClient;
use App\Models\Income;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

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
        $now = Carbon::now()->format('Y-m-d');

        $queryParams = [
            'dateFrom' => '2000-11-22',
            'dateTo' => $now,
            'limit' => 500,
            'page' => 1,
        ];
        $data = $orderHttpClient->auth(config('wbapi.auth_key'))->index($queryParams);

        if (isset($data['data'])) {
            $orders = collect($data['data']);
            $orders->each(function ($order) {
                Order::firstOrCreate($order);
            });
            return;
        }
        dump('Нет данных');
    }
}
