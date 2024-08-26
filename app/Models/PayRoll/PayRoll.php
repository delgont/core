<?php

namespace App\Models\PayRoll;

use Illuminate\Database\Eloquent\Model;

class PayRoll extends Model
{

    public function getHelloAttribute($value)
    {
        return json_decode($value);
    }
}
