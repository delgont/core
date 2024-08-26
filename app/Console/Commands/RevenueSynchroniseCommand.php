<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\OtherRevenue;


use App\Models\Any;
use App\Models\Accounting\Coa\Revenue;
use App\Models\Accounting\TermlyAccrualRevenue;

class RevenueSynchroniseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'revenue:sync';

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
        //app(OtherRevenue::class)->termly()->populate();
        $revenues = Revenue::whereHas('incomes', function($incomeQuery){
            $incomeQuery->current();
        })->with(['incomes', 'children' => function($childrenQuery){
            $childrenQuery->with(['incomes', 'children' => function($childrenQuery){
                $childrenQuery->with(['incomes']);
            }]);
        }])->get();

        foreach ($revenues as $revenue) {

            $children = $revenue->children->map(function($item, $key){
                $levelOneAmount = $item->incomes->sum('amount');
                $levelTwoAmount = $item->children->map(function($item, $key){
                    return new Any([
                        'amount' => $item->incomes->sum('amount')
                    ]);
                })->sum('amount');
                return new Any([
                    'amount' => ($levelOneAmount + $levelTwoAmount)
                ]);
            });
            $amount =  ($revenue->incomes->sum('amount') + $children->sum('amount'));
            (true) ? TermlyAccrualRevenue::updateOrCreate(['term_id' => term()->id, 'account_id' => $revenue->id],['amount' => $amount, 'term_id' => term()->id, 'account_id' => $revenue->id]) : '';
        }
        $this->info('Revenue Sync successfully...');
    }
}
