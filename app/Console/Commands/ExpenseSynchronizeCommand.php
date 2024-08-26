<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Accounting\Coa\Expense;
use App\Support\Models\Any;
use App\Models\Accounting\Expense\ExpenseTransaction;


class ExpenseSynchronizeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expense:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronise expense entries ...';

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
        $expenses = ExpenseTransaction::current()->whereHas('items')->with(['items'])->get();

        $expenses->map(function($item, $key){
            $total = $item->items->map(function($item, $key){
                return new Any([
                    'amount' => $item->rate * $item->quantity
                ]);
            })->sum('amount');

            $item->amount = $total;
            $item->save();
        });
    }
}
