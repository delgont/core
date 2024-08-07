<?php

namespace Delgont\Core\Cache;

use Illuminate\Support\Facades\Cache;

abstract class ModelCacheKeys
{
    
    protected function getCacheKeys()
    {
        return (new \ReflectionClass($this))->getConstants();
    }

    /**
     * Clear All Model Cached Data
     */
    public function clearCache() : void
    {
        $keys = $this->getCacheKeys();
        if(count($keys) > 0){
            foreach ($keys as $key => $value) {
                Cache::forget($value);
            }
        }
    }

    protected function clearFromCache($key) : void
    {
        Cache::forget($key);
    }
}
