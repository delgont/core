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
    public static function clearCache() : void
    {
        // If called statically, create an instance and use that to clear cache
        $instance = new static();
        $instance->clearAllCache();
    }

    public function clearAllCache() : void
    {
        $keys = $this->getCacheKeys();
        if (count($keys) > 0) {
            foreach ($keys as $value) {
                Cache::forget($value);
            }
        }
    }


    public function clearFromCache($key) : void
    {
        Cache::forget($key);
    }

    public static function forget($key) : void
    {
        $instance = new static();
        $instance->clearFromCache($key);
    }


    public static function clearCacheUpToLastPage($perPage, $lastPage, $cachePrefix)
    {
        $instance = new static();
        $instance->clearPaginatedCache($perPage, $lastPage, $cachePrefix);
       
    }

    public function clearPaginatedCache($perPage, $lastPage, $cachePrefix)
    {
        for ($page = 1; $page <= $lastPage; $page++) {
            $cacheKey = $cachePrefix.':page:$page:perPage:$perPage';
            Cache::forget($cacheKey);
        }
    }

}
