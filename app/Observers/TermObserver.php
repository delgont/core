<?php

namespace App\Observers;

use App\Entities\Term;
use App\Cache\TermCacheKeys;

class TermObserver
{
    /**
     * Handle the Term "created" event.
     */
    public function created(Term $term): void
    {
        //Clear Term Cached Data
        app(TermCacheKeys::class)->clearCache();
    }

    /**
     * Handle the Term "updated" event.
     */
    public function updated(Term $term): void
    {
        //Clear Term Cached Data
        app(TermCacheKeys::class)->clearCache();
    }

    /**
     * Handle the Term "deleted" event.
     */
    public function deleted(Term $term): void
    {
        //Clear Term Cached Data
        app(TermCacheKeys::class)->clearCache();
    }

    /**
     * Handle the Term "restored" event.
     */
    public function restored(Term $term): void
    {
        //Clear Term Cached Data
        app(TermCacheKeys::class)->clearCache();
    }

    /**
     * Handle the Term "force deleted" event.
     */
    public function forceDeleted(Term $term): void
    {
        //Clear Term Cached Data
        app(TermCacheKeys::class)->clearCache();
    }
}
