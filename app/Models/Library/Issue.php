<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Model;

use App\Models\Library\Member;


class Issue extends Model
{
    protected $with = ['member'];

    public function scopeCheckedOut($query)
    {
        return $query->whereNull('return_date');
    }


    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
