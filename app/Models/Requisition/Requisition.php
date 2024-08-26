<?php
namespace App\Models\Requisition;

use Illuminate\Database\Eloquent\Model;

use App\Models\Department\Department;
use App\Models\Employee\Employee;
use App\Models\Accounts\AccountingPeriod;

use App\Models\Requisition\RequisitionItem;
use App\Models\Expense\Expense;

class Requisition extends Model
{

    protected $with = ['department', 'requester:id,first_name,last_name','items'];



     //Get current expenses
     public function scopeCurrent($query)
     {
         return $query->whereHas('accountingPeriod', function($accountingPeriodQuery){
             $accountingPeriodQuery->whereId(option('current_accounting_period_id'));
         });
     }

     
    //Get Purchase Requisitions
    public function scopePurchase($query)
    {
        return $query->where('type', 'purchase');
    }

    //Get requisitions that have been sent for approval
    public function scopeSentForApproval($query)
    {
        return $query->where('send_for_approval', 1);
    }

    //Get requisitions that have been approved
    public function scopeApproved($query)
    {
        return $query->whereNotNull('approved_on');
    }

    //Get locally entered requisitions
    public function scopeLocal($query)
    {
        return $query->whereFormat('paper');
    }

    //Get digital reuisitions
    public function scopeDigital($query)
    {
        return $query->whereFormat('digital');
    }

    //Get paper format requisitions
    public function scopePaper($query)
    {
        return $query->whereFormat('paper');
    }
    

    //Get the department to which the requisition belongs
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    //Get the employee who approved the requisition
    public function approvedBy()
    {
        return $this->belongsTo(Employee::class, 'approved_by');
    }

    //Get the employee who requested the requisition
    public function requester()
    {
        return $this->belongsTo(Employee::class, 'requested_by');
    }

     //Get the employee who authorized the requisition
     public function authorizedBy()
     {
         return $this->belongsTo(Employee::class, 'authorized_by');
     }

     //Get the accounting period to which the requisition belong
     public function accountingPeriod()
     {
        return $this->belongsTo(AccountingPeriod::class, 'accounting_period_id');
     }

     //Get the requistion items
     public function items()
     {
        return $this->hasMany(RequisitionItem::class);
     }

     //Get the expense associated with this requisition
     public function expense()
     {
        return $this->hasOne(Expense::class);
     }

  
}
