<?php

namespace App\Console\Commands;

use App\HttpClients\IncomeHttpClient;
use App\Models\Income;
use Illuminate\Console\Command;

class IncomeGoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'income:go';

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
        $incomeHttpClient = IncomeHttpClient::make();
        $queryParams = [
            'dateFrom' => '2000-11-21',
            'dateTo' => '2025-11-21',
            'limit' => 600,
        ];
        $data = $incomeHttpClient->auth(config('wbapi.auth_key'))->index($queryParams);
        if (isset($data['data'])) {
            $incomes = collect($data['data']);
            $incomes->each(function ($income) {
                Income::firstOrCreate($income);
            });
            return;
        }
        dump('Нет данных');
    }
}
