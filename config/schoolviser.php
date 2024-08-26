<?php

return [

  'school_name' => 'Delgont Primary School',
  'logo' => 'images/logo.svg',

  'version' => env('APP_VERSION', 'Dev'),

  'admin_layout' => env('ADMIN_LAYOUT', 'admin.layouts.master'),

  //'admin_layout' => 'admin.layouts.horizontal',

 /**
  * School type -> primary, secondary, tertiary
  */

  'type' => 'secondary',

  'public_storage' => 'public/storage',

  /**
   * Accounting Configuration Settings
   */

   //if false the expenses for the entire accounting period will be show
   'termly_expenses' => true, 
   'associate_expense_with_cheque' => false,
   //Require cheque number when capturing expenses 
   'require_cheque_number' => false,

   'modules' => [
    //'student',
    //'fee',
    'accounting',
    //'requisition',
    //'admission',
    //'course',
    //'applicant',
    //'user'
   ],


   'package' => 'premium'

];