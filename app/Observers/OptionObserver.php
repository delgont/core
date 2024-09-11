<?php

namespace App\Observers;

use App\Entities\Option;
 
use App\Cache\CacheKeys\OptionCacheKeys;

class OptionObserver
{
    /**
     * Handle the Option "created" event.
     */
    public function created(Option $model): void
    {
        OptionCacheKeys::clearCache();
        OptionCacheKeys::clearCacheUpToLastPage(15,100, 'options');
    }

    /**
     * Handle the Option "updated" event.
     */
    public function updated(Option $model): void
    {
        OptionCacheKeys::clearCache();
        OptionCacheKeys::clearCacheUpToLastPage(15,100, 'options');

    }

    /**
     * Handle the Option "deleted" event.
     */
    public function deleted(Option $model): void
    {
        OptionCacheKeys::clearCache();
        OptionCacheKeys::clearCacheUpToLastPage(15,100, 'options');

    }

    /**
     * Handle the Option "restored" event.
     */
    public function restored(Option $model): void
    {
        OptionCacheKeys::clearCache();
        OptionCacheKeys::clearCacheUpToLastPage(15,100, 'options');

    }

    /**
     * Handle the Option "force deleted" event.
     */
    public function forceDeleted(Option $model): void
    {
        OptionCacheKeys::clearCache();
        OptionCacheKeys::clearCacheUpToLastPage(15,100, 'options');

    }
}
