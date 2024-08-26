<?php

namespace App\Models\Bill;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasAmountAttribute;


class BillPayment extends Model
{
    use HasAmountAttribute;

    protected $table = 'expense_transactions';
}
