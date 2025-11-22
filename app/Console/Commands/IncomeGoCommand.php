<?php

namespace App\Console\Commands;

use App\HttpClients\IncomeHttpClient;
use App\Models\Income;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

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
        $now = Carbon::now()->format('Y-m-d');
        $incomeHttpClient = IncomeHttpClient::make();
        $queryParams = [
            'dateFrom' => $now,
            'dateTo' => $now,
            'limit' => 500,
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
