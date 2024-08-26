<?php

namespace App;

use Delgont\Auth\PermissionRegistrar;

class AccountingPermissionRegistrar extends PermissionRegistrar
{
    protected $group = 'accounting';


    const CAN_MANAGE_ACCOUNTING = 'can_manage_accounting';
    const CAN_ACCESS_ACCOUNTING_OVERVIEW = 'can_access_accounting_overview';

    //Chart Of Accounts
    const CAN_VIEW_CHART_OF_ACCOUNTS = 'can_view_chart_of_accounts';
    const CAN_EDIT_CHART_OF_ACCOUNTS = 'can_edit_chart_of_accounts';
    const CAN_DELETE_CHART_OF_ACCOUNTS = 'can_delete_chart_of_accounts';
    const CAN_CREATE_CHART_OF_ACCOUNTS = 'can_create_chart_of_accounts';
    const CAN_PROTECT_CHART_OF_ACCOUNTS = 'can_protect_chart_of_accounts';

    //Expenses permissions
    const CAN_VIEW_EXPENSES = 'can_view_expenses';
    const CAN_RECORD_EXPENSES = 'can_record_expenses';
    const CAN_DELETE_EXPENSE = 'can_delete_expense';
    const CAN_EDIT_EXPENSE = 'can_edit_expense';
    const CAN_UPDATE_EXPENSE = 'can_update_expense';
    const CAN_VIEW_REVENUE_SUMMARY = 'can_view_revenue_summary';

    const CAN_VIEW_BILLS = 'can_view_bills';

    const CAN_VIEW_BUDGET = 'can_view_budget';
    const CAN_VIEW_EXPENSE_PROJECTIONS = 'can_view_expense_projections';

    //Revenue & Income
    const CAN_VIEW_REVENUE = 'can_view_revenue';
    const CAN_ADD_INCOME = 'can_add_income';

    public function descriptions()
    {
        return [
         self::CAN_MANAGE_ACCOUNTING => 'User will be able to have access to accouting links and may not be able to perform any action unless given prior permission',
         self::CAN_VIEW_BILLS => 'User will be able to view graphical representaion of students per class',
         self::CAN_PROTECT_CHART_OF_ACCOUNTS => 'User will be able to mark chart of account as protected ... protected chart of accounts can not be deleted or edited'
        ];
    }
    
}