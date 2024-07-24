<?php

namespace Delgont\Core\Cache;

use Illuminate\Support\Facades\Cache;

abstract class ModelCacheKeys
{
    
    protected function getCacheKeys()
    {
        return ($this->cacheKeys) ? $this->cacheKeys : (new \ReflectionClass($this))->getConstants();
    }

    /**
     * Clear All Model Cached Data
     */
    public function clearCache() : void
    {
        $keys = $this->cacheRegistry->getCacheKeys();
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
