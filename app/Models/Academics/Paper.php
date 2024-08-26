<?php

namespace App\Models\Academics;

use Illuminate\Database\Eloquent\Model;

use App\Models\Academics\Subject;

class Paper extends Model
{
    //


    //compulsory papers
    public function scopeCompulsory($query)
    {
        return $query->whereCompulsory('1');
    }

    //Get the subject to which the paper belong
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
