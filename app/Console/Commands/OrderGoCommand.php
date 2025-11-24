<?php

namespace App\Console\Commands;

use App\HttpClients\OrderHttpClient;
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
        $now = Carbon::now()->format('Y-m-d');
        $orderHttpClient = OrderHttpClient::make();
        $orderHttpClient->auth(config('wbapi.auth_key'));

        $queryParams = [
            'dateFrom' => '2000-01-01',
            'dateTo' => $now,
            'limit' => 500,
        ];

        $orderHttpClient->saveToDb($queryParams, Order::class);

    }
}
