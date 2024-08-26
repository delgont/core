<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Option extends Model
{
    
    protected $table = 'options';

    protected $fillable = ['key', 'value', 'identifier'];


    /**
    * Get General Settings Options
    */
    public function scopeGeneralSettings($query)
    {
        return $query->where('identifier','general_settings');
    }

    /**
     * Get option of specific key
     */
    public function scopeOfKey( $query, $key, $identifier = null )
    {
        return ($identifier) ? $query->where('key', $key)->where('identifier', $identifier) : $query->where('key', $key);
    }

    /**
     * Get option of specific identifier
     */
    public function scopeOfIdentifier( $query, $identifier )
    {
        return $query->where('identifier', $identifier);
    }

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
