<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Room;
use App\Models\Asset\Asset;

class Room extends Model
{
    //Get the building to which the room belong
    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class, 'location_id');
    }
}
