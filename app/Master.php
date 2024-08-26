<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->morphOne('App\User', 'user');
    }
    
}