<?php

namespace App\Models\Concerns;

use App\Models\ModelOption;

trait ModelHasOptions
{

    /**
     * Model Options
     */
    public function options()
    {
        return $this->morphMany(ModelOption::class, 'model');
    }

    /**
     * Get model options
     */
    public function getOptions()
    {
        return $this->options()->get();
    }

    /**
     * Get model option
     * @return /Illuminate/Database/Eloquent/Model
     */
    public function getOption($key, $firstOrFail = false)
    {
        return ($firstOrFail) ? $this->options()->where('key', $key)->firstOrFail() : $this->options()->where('key', $key)->first();
    }

    /**
     * Set model options
     */
    public function setOption($key, $value, $group = null)
    {
        $this->options()->updateOrCreate(['key' => $key], [
            'key' => $key,
            'value' => $value,
            'group' => $group
        ]);
        return $this;
    }

    public function setOptions($options, $group = null)
    {
        foreach ($options as $key => $value) {
            $this->options()->updateOrCreate(['key' => $key], [
                'key' => $key,
                'value' => $value,
                'group' => $group
            ]);
        }
        return $this;
    }

}
