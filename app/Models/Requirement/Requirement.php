<?php

namespace App\Models\Requirement;

use Illuminate\Database\Eloquent\Model;

use App\Models\Term;
use App\Models\Clazz;
use App\Models\UnitOfMeasure;
use App\Models\Requirement\RequirementItem;


class Requirement extends Model
{
    protected $guarded = [];


    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id');
    }

    public function item()
    {
        return $this->belongsTo(RequirementItem::class, 'requirement_item_id');
    }

    public function clazz()
    {
        return $this->belongsTo(Clazz::class, 'clazz_id');
    }

    public function unitOfMeasure()
    {
        return $this->belongsTo(UnitOfMeasure::class, 'unit_of_measure_id');
    }
}
