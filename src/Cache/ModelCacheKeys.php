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

    /**
     * Clear paginated cache entries up to the specified last page.
     *
     * This method creates a new instance of the class and calls the 
     * `clearPaginatedCache` method to remove cache entries for paginated 
     * data, from the first page up to the specified last page.
     *
     * @param int $perPage The number of items per page for the pagination.
     * @param int $lastPage The last page number up to which the cache should be cleared.
     * @param string $cachePrefix The prefix used for the cache keys to identify paginated entries.
     * @return void
     */
    public static function clearCacheUpToLastPage($perPage, $lastPage, $cachePrefix)
    {
        $instance = new static();
        $instance->clearPaginatedCache($perPage, $lastPage, $cachePrefix);
       
    }

    /**
     * Clear cache entries for paginated data up to the specified last page.
     *
     * @param int $perPage The number of items per page for the pagination.
     * @param int $lastPage The last page number for which the cache should be cleared.
     * @param string $cachePrefix The prefix used for identifying the cache keys related to pagination.
     * @return void
     */
    public function clearPaginatedCache($perPage, $lastPage, $cachePrefix)
    {
        for ($page = 1; $page <= $lastPage; $page++) {
            $cacheKey = $cachePrefix.':page:' . $page . ':perPage:' . $perPage;
            Cache::forget($cacheKey);
        }
    }

}
