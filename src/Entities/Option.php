<?php

namespace Delgont\Core\Entities;

use Illuminate\Database\Eloquent\Model;

use Delgont\Core\Concerns\ModelHasMeta;

class Option extends Model
{
    use ModelHasMeta;
    
    protected $guarded = [];
    
}
