<?php

namespace App\Console\Commands;

use App\Models\Income;
use Illuminate\Console\Command;

class GoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'go';

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
        $this->call('income:go');
        $this->call('order:go');
        $this->call('sale:go');
        $this->call('stock:go');
    }
}
