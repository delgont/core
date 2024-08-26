<?php

namespace App\Console\Commands\Accounting;

use Illuminate\Console\Command;

use App\Models\Accounting\Coa\Bank;
use App\Models\Accounting\BankedSchoolFeeSum;
use App\Models\Accounting\BankedDepositSum;
use App\Models\Accounting\BankExpenseWithdrawalSum;
use App\Models\Accounting\BankWithdrawalSum;
use App\Models\Accounting\BankIncomeSum;


class SyncBankCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bank:sync';

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
        $banks = Bank::with(['currentFeeDeposits', 'currentDeposits', 'currentExpenses', 'currentWithdrawals', 'currentIncomes' => function($incomeQuery){
            $incomeQuery->received();
        }])->get();

        $banks->map(function($item, $key){

            BankedSchoolFeeSum::updateOrCreate(['bank_id' => $item->id, 'accounting_period_id' => period()->id],[
                'amount' => $item->currentFeeDeposits->sum('amount'),
                'accounting_period_id' => period()->id,
                'bank_id' => $item->id
            ]);
            
            BankedDepositSum::updateOrCreate(['bank_id' => $item->id, 'accounting_period_id' => period()->id],[
                'amount' => $item->currentDeposits->sum('amount'),
                'accounting_period_id' => period()->id,
                'bank_id' => $item->id
            ]);

            BankExpenseWithdrawalSum::updateOrCreate(['bank_id' => $item->id, 'accounting_period_id' => period()->id],[
                'amount' => $item->currentExpenses->sum('amount'),
                'accounting_period_id' => period()->id,
                'bank_id' => $item->id
            ]);

            BankWithdrawalSum::updateOrCreate(['bank_id' => $item->id, 'accounting_period_id' => period()->id],[
                'amount' => $item->currentWithdrawals->sum('amount'),
                'accounting_period_id' => period()->id,
                'bank_id' => $item->id
            ]);

            BankIncomeSum::updateOrCreate(['bank_id' => $item->id, 'accounting_period_id' => period()->id],[
                'amount' => $item->currentIncomes->sum('amount'),
                'accounting_period_id' => period()->id
            ]);

        });

        $this->info('good');
        return 0;
    }
}
