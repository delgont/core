<?php

namespace App\Concerns;

/**
 * Observers
 */
use App\Observers\IncomeObserver;
use App\Observers\AccountingPeriodObserver;
use App\Observers\ExpenseTransactionObserver;
use App\Observers\Accounting\BankDepositObserver;
use App\Observers\Accounting\BankWithdrawalObserver;

use App\Observers\ExpenseObserver;
use App\Observers\Accounting\RevenueObserver;


/**
 * Models
 */
use App\Models\Accounting\Income;
use App\Models\Accounting\AccountingPeriod;
use App\Models\Accounting\Expense\ExpenseTransaction;
use App\Models\Accounting\BankDeposit;
use App\Models\Accounting\BankWithdrawal;

use App\Models\Accounting\Coa\Expense;
use App\Models\Accounting\Coa\Revenue;



trait BootAccountingObservers
{
    private function bootAccountingObservers() : void
    {
        AccountingPeriod::observe(AccountingPeriodObserver::class);
        Income::observe(IncomeObserver::class);
        ExpenseTransaction::observe(ExpenseTransactionObserver::class);
        BankDeposit::observe(BankDepositObserver::class);
        BankWithdrawal::observe(BankWithdrawalObserver::class);

        Expense::observe(ExpenseObserver::class);
        Revenue::observe(RevenueObserver::class);
    }
}