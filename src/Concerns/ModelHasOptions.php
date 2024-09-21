<?php
namespace Delgont\Core\Concerns;

use Delgont\Core\Entities\ModelOption;

trait ModelHasOptions {

    public function options()
    {
        return $this->morphMany(ModelOption::class, 'model');
    }

    public function option($key)
    {
        return $this->morphMany(ModelOption::class, 'model')->where('key', $key);
    }


    public function scopeWithOptions($query, $options = null)
    {
        if (!is_null($options)) {
            if (is_string($options)) {
                return $query
                ->with(['options' => function($q) use ($options){
                    $q->where('key', $options);
                }]);
            }
            if (is_array($options)) {
                return $query
                ->with(['options' => function($q) use ($options) {
                    $q->whereIn('key', $options);
                }]);
            }
        }
        return $query->with('options');
    }
    
}