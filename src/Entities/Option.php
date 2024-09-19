<?php

namespace Delgont\Core\Entites\Option;

use Illuminate\Database\Eloquent\Model;


class Option extends Model
{
    
    protected $table = 'options';

    protected $fillable = ['option_key', 'option_value'];

   /**
    * Get disabled options
    */
    public function scopeDisbled($query)
    {
        return $query->whereDisabled('1');
    }

    /**
     * Set or Set and Get the option value
     */
    public function value($value = null) : ? string
    {
        if ($value) {
            $this->{$this->getTable().'.'.'option_value'} = $value;
            $this->save();
            return $value;
        }
        return $this->{'option_value'};
    }

}
