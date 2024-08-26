<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


use App\Models\UnitOfMeasure;

class InventoryItem extends Model
{
    use SoftDeletes;
    //Get item unit of measure
    public function unitOfMeasure()
    {
        return $this->belongsTo(UnitOfMeasure::class);
    }

    //Get the stockins for this item
    public function stockIns()
    {
        return $this->hasMany(InventoryStockIn::class);
    }
}
