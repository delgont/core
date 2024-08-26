<?php

namespace App\Console\Commands\Accounting;

use Illuminate\Console\Command;

class CacheExpenseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expense:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache expense transactions, expense summaries';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
