<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelKeyValueProperty extends Model
{
    protected $guarded = [];

    public function scopeOfGroup($query, $group)
    {
        return $query->whereGroup($group);
    }
}
