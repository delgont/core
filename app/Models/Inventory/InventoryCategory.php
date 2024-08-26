<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class InventoryCategory extends Model
{

    //Get inventory items that belong to this category
    public function items()
    {
        return $this->hasMany(InventoryItem::class, 'inventory_category_id');
    }
}
