<?php

namespace App\Models;

use App\Models\Room;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $guarded = [];
    
    public function rooms()
    {
        return $this->hasMany(Room::class, 'building_id');
    }

    public function buildingType()
    {
        return $this->morphTo();
    }
}
