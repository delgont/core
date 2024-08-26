<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

use App\Option;


class OptionObserver
{


    public function __construct()
    {
    }

    /**
     * Handle the option "created" event.
     *
     * @param  \App\Option  $option
     * @return void
     */  
    public function created(Option $option)
    {
        Cache::put($option->key, $option->toArray(), now()->addMinutes(60));
    }

    /**
     * Handle the option "updated" event.
     *
     * @param  \App\Option  $option
     * @return void
     */
    public function updated(Option $option)
    {
    }

    /**
     * Handle the option "deleted" event.
     *
     * @param  \App\Option  $option
     * @return void
     */
    public function deleted(Option $option)
    {

    }

    /**
     * Handle the option "restored" event.
     *
     * @param  \App\Option  $option
     * @return void
     */
    public function restored(Option $option)
    {
    }

    /**
     * Handle the option "force deleted" event.
     *
     * @param  \App\Option  $option
     * @return void
     */
    public function forceDeleted(Option $option)
    {

    }
}
