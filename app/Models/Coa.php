<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//Related Models
use App\Models\Expense\Expense;
use App\Models\Bill\Bill;

use App\Models\Asset\Asset;
use App\Models\Asset\AssetType;
use App\Models\Expense\ExepnseSummary;


class Coa extends Model
{
    //
    protected $guarded = [];

    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function fixedAssets()
    {
        return $this->hasManyThrough(Asset::class, AssetType::class, 'asset_account_id', 'asset_type_id');
    }

    //Get asset accounts
    public function scopeAsset($query)
    {
        return $query->whereType('asset');
    }

    //Get expense accounts
    public function scopeExpense($query)
    {
        return $query->whereType('expense');
    }

     //Get expense accounts
     public function scopeRevenue($query)
     {
         return $query->whereType('revenue');
     }

      //Get expense accounts
      public function scopeLiability($query)
      {
          return $query->whereType('liability');
      }

     //Get expenses that belong to this account
     public function expenses()
     {
        return $this->hasMany(Expense::class, 'account_id');
     }

     public function bills()
     {
        return $this->hasMany(Bill::class, 'account_id');
     }

     public function children()
     {
         return $this->hasMany(Coa::class, 'parent_id');
     }

     public function summaries()
     {
        return $this->hasMany(ExepnseSummary::class, 'account_id');
     }
 
}
