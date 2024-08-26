<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Accounting\Coa\Expense;
use App\Models\Accounting\Coa\Revenue;

class AccountingSynchronizeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'accounting:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
       $this->call('expense:sync');

        $revenues = config('defaults.revenues');

        foreach ($revenues as $value) {
            # code...
            Revenue::updateOrCreate(['name' => $value], ['name' => $value]);
        }

        return 0;
    }
}
