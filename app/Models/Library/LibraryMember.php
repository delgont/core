<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Model;

class LibraryMember extends Model
{
    protected $with = ['member:id,first_name,last_name,photo'];

    protected $table = 'members';


    public function member()
    {
        return $this->morphTo();
    }

    public function scopeBlocked($query)
    {
        return $query->whereBlocked('1');
    }
}
