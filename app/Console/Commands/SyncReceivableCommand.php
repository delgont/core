<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Any;
use App\Models\Accounting\Coa\Revenue;
use App\Models\Accounting\TermlyReceivable;


class SyncReceivableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'receivable:sync';

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
        $revenues = Revenue::with(['incomes' => function($incomeQuery){
            $incomeQuery->notReceived()->current();
        }, 'children' => function($childrenQuery){
            $childrenQuery->with(['incomes' => function($incomeQuery){
                $incomeQuery->notReceived()->current();
            }, 'children' => function($childrenQuery){
                $childrenQuery->with(['incomes' => function($incomeQuery){
                    $incomeQuery->notReceived()->current();
                }, 'children']);
            }]);
        }])->get()->map(function($item, $key){
            return new Any([
                'id' => $item->id,
                'name' => $item->name,
                'amount' => $item->incomes->sum('amount') + $item->children->map(function($item, $key){
                    return new Any([
                        'id' => $item->id,
                        'name' => $item->name,
                        'amount' => $item->incomes->sum('amount') + $item->children->map(function($item, $key){
                            return new Any([
                                'id' => $item->id,
                                'name' => $item->name,
                                'amount' => $item->incomes->sum('amount') + $item->children->sum('amount')
                            ]);
                        })->sum('amount')
                    ]);
                })->sum('amount')
            ]);
        });

        foreach ($revenues as $revenue) {

            (true) ? TermlyReceivable::updateOrCreate(['term_id' => term()->id, 'account_id' => $revenue->id],['amount' => $revenue->amount, 'term_id' => term()->id, 'account_id' => $revenue->id]) : '';
        }
        return 0;
    }
}
