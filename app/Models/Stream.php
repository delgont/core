<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Clazz;

class Stream extends Model
{
    

    public function clazz()
    {
        return $this->belongsTo(Clazz::class);
    }
}
