<?php

namespace App\Models\Academics;

use Illuminate\Database\Eloquent\Model;

//Related Models
use App\Models\Academics\Paper;
use App\Models\Academics\Combination;
use App\Models\Academics\CombinationSubject;

class Subject extends Model
{

    protected $guarded = [];

    //OLevel Subjects
    public function scopeOLevel($query)
    {
        return $query->whereLevel('o');
    }

     //OLevel Subjects
     public function scopeALevel($query)
     {
         return $query->whereLevel('a');
     }

     //Core Subjects
     public function scopeCore($query)
     {
        return $query->whereCore('1');
     }

     //Subsidiary Subjects
     public function scopeSubsidiary($query)
     {
        return $query->whereSubsidiary('1');
     }


     //Get papers that belong to this subject
     public function papers()
     {
        return $this->hasMany(Paper::class, 'subject_id');
     }

      //Get combinations of the this combination
    public function combinations()
    {
        return $this->belongsToMany(Combination::class)->using(CombinationSubject::class);
    }
}
