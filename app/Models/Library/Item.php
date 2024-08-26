<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Model;

use App\Models\Library\ItemCopy;
use App\Models\Library\ItemType;


class Item extends Model
{

    public function scopeBooks($query)
    {
        return $query->whereHas('itemType', function($itemTypeQuery){
            $itemTypeQuery->whereName('book');
        });
    }

    public function copies()
    {
        return $this->hasMany(ItemCopy::class, 'item_id');
    }


    public function itemType()
    {
        return $this->belongsTo(ItemTYpe::class, 'item_type_id');
    }
    
}
