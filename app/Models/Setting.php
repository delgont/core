<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Setting extends Model
{
    protected $attributes = [
        'group' => 'setting'
    ];

    protected $guarded = [];

    protected $table = 'model_key_value_properties';

    protected static function booted()
    {
        static::addGlobalScope('settingGroupOnly', function(Builder $builder){
            $builder->where('group', 'setting');
        });
    }

    

    public function model()
    {
        return $this->morphTo();
    }

    //Get setting of specified key
    public function scopeOfKey($query, $key)
    {
        return $query->where('key', $key);
    }

    //Get setting of specified model class
    public function scopeOfModel($query, $modelObject)
    {
        return $query->where('model_id', $modelObject->id)->where('model_type', get_class($modelObject));
    }
}
