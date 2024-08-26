<?php

namespace App\Models\Academics;

use Illuminate\Database\Eloquent\Model;

namespace App\Models\Academics\Subject;
namespace App\Models\Academics\CombinationSubject;

class Combination extends Model
{
    
    //SCience Combinations
    public function scopeScience($query)
    {
        return $query->whereType('science');
    }

    //Art Combinations
    public function scopeArt($query)
    {
        return $query->whereType('art');
    }


    //Get subjects of the this combination
    public function subjects()
    {
        return $this->belongsToMany(Subject::class)->using(CombinationSubject::class);
    }
}
