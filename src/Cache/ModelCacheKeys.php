<?php

namespace Delgont\Core\Cache;

use Illuminate\Support\Facades\Cache;
use ReflectionClass;

/**
 * Abstract base class for defining and managing cache keys for models.
 *
 * Provides utility methods to clear cache entries, handle paginated cache,
 * and append suffixes to cache keys. Subclasses should define constants
 * representing specific cache keys for their models.
 */
abstract class ModelCacheKeys
{
    /**
     * Retrieve all cache key constants defined in the subclass.
     *
     * @return array<string, string> Array of constant name => value pairs.
     */
    protected function getCacheKeys()
    {
        return (new \ReflectionClass($this))->getConstants();
    }

    /**
     * Clear all cached data for the model.
     *
     * This static method instantiates the subclass and calls `clearAllCache`.
     *
     * @param mixed|null $id Optional identifier to clear cache entries scoped to a specific ID.
     * @return void
     */
    public static function clearCache($id = null) : void
    {
        $instance = new static();
        $instance->clearAllCache($id);
    }

    /**
     * Clear all cache entries defined by the model's constants.
     *
     * Iterates through all constants and removes their cache entries.
     * If an ID is provided, also clears entries with the ID appended.
     *
     * @param mixed|null $id Optional identifier to clear cache entries scoped to a specific ID.
     * @return void
     */
    public function clearAllCache($id = null) : void
    {
        $keys = $this->getCacheKeys();
        
        if (count($keys) > 0) {
            foreach ($keys as $value) {
                Cache::forget($value);
                if ($id) {
                    Cache::forget($value . ':' . $id);
                }
            }
        }
    }

    /**
     * Clear a specific cache entry by key.
     *
     * @param string $key The cache key to remove.
     * @return void
     */
    public function clearFromCache($key) : void
    {
        Cache::forget($key);
    }

    /**
     * Static helper to clear a specific cache entry.
     *
     * @param string $key The cache key to remove.
     * @return void
     */
    public static function forget($key) : void
    {
        $instance = new static();
        $instance->clearFromCache($key);
    }

    /**
     * Clear paginated cache entries up to the specified last page.
     *
     * @param int $perPage Number of items per page.
     * @param int $lastPage Last page number to clear.
     * @param string $cachePrefix Prefix used for paginated cache keys.
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
     * @param int $perPage Number of items per page.
     * @param int $lastPage Last page number to clear.
     * @param string $cachePrefix Prefix used for paginated cache keys.
     * @return void
     */
    public function clearPaginatedCache(int $perPage, int $lastPage, $cachePrefix)
    {
        for ($page = 1; $page <= $lastPage; $page++) {
            $cacheKey = $cachePrefix . self::appendPaginationCacheSuffix($perPage, $page);
            Cache::forget($cacheKey);
        }
    }

    /**
     * Generate a suffix for paginated cache keys.
     *
     * @param int $perPage Number of items per page.
     * @param int $page Current page number.
     * @return string The generated suffix.
     */
    public static function paginatedCacheSuffix(int $perPage, int $page) : string 
    {
        return 'perpage:' . $perPage . ':page:' . $page;
    }

    /**
     * Append a pagination suffix to a cache key.
     *
     * @param int $perPage Number of items per page.
     * @param int $page Current page number.
     * @return string The generated suffix.
     */
    public static function appendPaginationCacheSuffix(int $perPage, int $page) : string 
    {
        return 'perpage:' . $perPage . ':page:' . $page;
    }
    
    /**
     * Append arbitrary parts to a cache key.
     *
     * @param bool $appendSymbol Whether to append a trailing colon.
     * @param mixed ...$parts Parts to join into the suffix.
     * @return string The generated suffix.
     */
    public static function appendCacheSuffix(bool $appendSymbol, ...$parts)
    {
        $filtered = array_filter($parts, fn($p) => $p !== null && $p !== '');

        $key = implode(':', $filtered);

        if ($appendSymbol) {
            $key .= ':';
        }
        return $key;
    }

    
    /**
     * Get all cache key constants whose names start with a given prefix.
     *
     * @param string $prefix
     * @return array
     */
    public static function getCacheKeysStarting(string $prefix, $value = true): array
    {
        $reflection = new ReflectionClass(static::class);
        $constants  = $reflection->getConstants();

        $keys = [];
        foreach ($constants as $name => $value) {
            if (str_starts_with($name, $prefix)) {
                $keys[$name] = $value;
            }
        }

        return ($value) ? array_values($keys) : $keys;
    }

    /**
     * Get all cache key constants whose names end with a given suffix.
     *
     * @param string $suffix
     * @return array
     */
    public static function getCacheKeysEnding(string $suffix, $value = true): array
    {
        $reflection = new ReflectionClass(static::class);
        $constants  = $reflection->getConstants();

        $keys = [];
        foreach ($constants as $name => $value) {
            if (str_ends_with($name, $suffix)) {
                $keys[$name] = $value;
            }
        }

        return ($value) ? array_values($keys) : $keys;

    }

    /**
     * Get all cache key constants whose names contain a given substring.
     *
     * @param string $needle
     * @param bool $value Return only values (true) or name=>value pairs (false)
     * @return array
     */
    public static function getCacheKeysContaining(string $needle, bool $value = true): array
    {
        $reflection = new \ReflectionClass(static::class);
        $constants  = $reflection->getConstants();

        $keys = [];
        foreach ($constants as $name => $val) {
            if (str_contains($name, $needle)) {
                $keys[$name] = $val;
            }
        }

        return $value ? array_values($keys) : $keys;
    }

    /**
     * Get all cache key constants whose names start with a prefix AND end with a suffix.
     *
     * @param string $prefix
     * @param string $suffix
     * @param bool $value Return only values (true) or name=>value pairs (false)
     * @return array
     */
    public static function getCacheKeysStartingAndEnding(string $prefix, string $suffix, bool $value = true): array
    {
        $reflection = new \ReflectionClass(static::class);
        $constants  = $reflection->getConstants();

        $keys = [];
        foreach ($constants as $name => $val) {
            if (str_starts_with($name, $prefix) && str_ends_with($name, $suffix)) {
                $keys[$name] = $val;
            }
        }

        return $value ? array_values($keys) : $keys;
    }

   /**
     * Clear all cache entries whose constant names start with a given prefix.
     *
     * @param string $prefix
     * @param array|string $appendParts Values to append (companyId, studentId, etc.)
     * @param bool $appendSymbol Whether to add a trailing colon
     */
    public static function clearCacheWithKeysStarting(string $prefix, array|string $appendParts)
    {
        $cacheKeys = self::getCacheKeysStarting($prefix, true);
        $appendParts = is_array($appendParts) ? $appendParts : [$appendParts];

        foreach ($cacheKeys as $key) {
            $suffix = self::appendCacheSuffix(false, ...$appendParts);
            self::forget($key . $suffix);
        }
    }

    /**
     * Clear all cache entries whose constant names end with a given suffix.
     *
     * @param string $suffix
     * @param array|string $appendParts Values to append (companyId, studentId, etc.)
     * @param bool $appendSymbol Whether to add a trailing colon
     */
    public static function clearCacheWithKeysEnding(string $suffix, array|string $appendParts)
    {
        $cacheKeys = self::getCacheKeysEnding($suffix, true);
        $appendParts = is_array($appendParts) ? $appendParts : [$appendParts];

        foreach ($cacheKeys as $key) {
            $suffix = self::appendCacheSuffix(false, ...$appendParts);
            self::forget($key . $suffix);
        }
    }


}
