<?php

namespace App\Models\Academics;

use Illuminate\Database\Eloquent\Model;

use App\Models\Term;
use App\Models\Clazz;
use App\Models\Stream;
use App\Models\Academics\Subject;

class Routine extends Model
{
    
    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function clazz()
    {
        return $this->belongsTo(Clazz::class);
    }

    public function stream()
    {
        return $this->belongsTo(Stream::class);
    }
    
}
