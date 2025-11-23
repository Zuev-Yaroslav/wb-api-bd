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
        $incomeHttpClient->auth(config('wbapi.auth_key'));

        for ($i = 1; true; $i++) {
            $queryParams = [
                'dateFrom' => '2000-01-01',
                'dateTo' => $now,
                'limit' => 500,
                'page' => $i,
            ];

            $data = $incomeHttpClient->index($queryParams);
            sleep(2);
            if (isset($data['data'])) {
                $incomes = collect($data['data']);
                if ($incomes->isEmpty()) {
                    break;
                }
                $incomes->each(function ($income) {
                    Income::create($income);
                });
                dump($i);
            } else {
                dump('Нет данных');
                break;
            }
        }

    }
}
