<?php
namespace Delgont\Core\Cache;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


trait HandlesModelCaching
{
    /**
     * Indicates wheather to get data from the cache storage
     * @var bool
     */
    protected $fromCache = false;

    /**
     * How long data should stay in cache
     * @var int
     */
    protected $cacheExpiry = 1440;

    /**
     * whether to rember the data or not
     * @var bool
     */
    protected $remember = false;


    /**
     * Model cache key prefix
     */
    protected $cachePrefix;


    /**
     * Repository Model
     */
    protected $model;



    /**
     * Get cache expiry time
     * @var int
     */
    public function getCacheExpiry()
    {
        return $this->cacheExpiry;
    }


     /**
     * Set cache expiry time
     * @var this
     */
    public function setCacheExpiry($ttl)
    {
        $this->cacheExpiry = $ttl;
        return $this;
    }

    /**
    * Whether to get data from cache if it exists
    * @var this
    */
    public function fromCache( ) : self
    {
        $this->fromCache = true;
        return $this;
    }

     /**
    * Whether to remember the data
    * @var this
    */
    public function remember( $customCacheKey = null )
    {
        $this->remember = true;
        $this->customCacheKey = $customCacheKey;
        return $this;
    }

    public function getCachePrefix()
    {
        return $this->cachePrefix;
    }


    public function setCachePrefix($prefix)
    {
        $this->cachePrefix = $prefix;
        return $this;
    }

    /**
     * Get hydrated model from cache
     * 
     * @param string $key
     * @param Illuminate\Database\Eloquent\Model $model
     * 
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function getModelFromCache($key, Model $model = null) : ? Model 
    {
        $cached = Cache::get($key);
        if($cached){
            $models = (!is_null($model)) ? $model::hydrate([$cached]) : $this->model::hydrate([$cached]);
            return $models[0] ?? null;
        }
        return null;
    }


    /**
     * Store model in cache
     * 
     * @param Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * 
     * @return bool
     */
    public function storeModelInCache( Model $model, $key = null )
    {
        return $this->writeToCache( $this->generateModelUnitCacheKey( $model, $key ), $model->toArray() );
    }

    public function storeCollectionInCache( Collection $collection, $cacheKey) : bool
    {
        return $this->writeToCache($cacheKey, $collection);
    }
   
    protected function storeInCache($key, $value) : bool
    {
        return $this->writeToCache( $key, $value );
    }

    /**
     * Write a value to the cache with a time-to-live (TTL) expressed in minutes.
     *
     * @param string $key   The unique cache key under which the value is stored.
     * @param mixed  $value The data to be cached (model, collection, paginator, etc.).
     * @return bool Always returns true after writing to cache.
     */
    protected function writeToCache(string $key, $value) : bool
    {
        Cache::put($key, $value, now()->addMinutes((int) $this->cacheExpiry));
        return true;
    }

    public function generateModelUnitCacheKey ( Model $model, $key = null ) : string 
    {
        return ($key) ? $key : $this->getCachePrefix($model).':'.$model->getKey();
    }


     /**
     * Store length aware paginator in cache
     * 
     * @param Illuminate\Pagination\LengthAwarePaginator $data
     * @param string $cacheKey
     * 
     * @return bool
     */
    public function storeLengthAwarePaginatorInCache( LengthAwarePaginator $data, $cacheKey) : bool
    {
        return $this->writeToCache($cacheKey, $data);
    }


    /**
     * Retrieve and cache data for a defined expiry period.
     *
     * @param string   $cacheKey  Unique cache key identifier
     * @param callable $function  Callback to fetch fresh data if cache is empty
     *
     * @return mixed Cached or freshly retrieved data
     */
    public function cached($cacheKey, $function)
    {
        if ($this->fromCache) {
            $data = Cache::get($cacheKey);
            if (!is_null($data)) {
                return $data;
            }

            $data = $function();

            // Use Carbon for minutes-based expiry (consistent with writeToCache)
            Cache::put($cacheKey, $data, now()->addMinutes((int) $this->cacheExpiry));

            return $data;
        }

        return $function();
    }

    /**
     * Retrieve and cache data indefinitely.
     *
     * This method behaves like `cached()`, but stores the result permanently
     * until explicitly removed from the cache.
     *
     * @param string   $cacheKey  Unique cache key identifier
     * @param callable $function  Callback to fetch fresh data if cache is empty
     *
     * @return mixed Cached or freshly retrieved data
     */
    public function cachedForever($cacheKey, $function)
    {
        $data = Cache::get($cacheKey);
        if (!is_null($data)) {
            return $data;
        }

        $data = $function();

        // Store permanently until manually cleared
        Cache::forever($cacheKey, $data);

        return $data;
    }



}