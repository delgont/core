<?php

namespace Delgont\Core\Repository;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use Delgont\Core\Entities\Option;
use Delgont\Core\Cache\OptionCacheKeys as CacheKeys;

class OptionRepository extends BaseRepository
{
    protected $cacheExpiry = '1440';
    protected $fromCache = true;

    public function __construct(Option $model)
    {
        parent::__construct($model);
    }

    public function  getOptions($group)
    {
        return $this->cached($group.':'.'options', function() use ($group){
            return $this->model->whereGroup($group)->get();
        });
    }

    public function findOption($option_key, $group)
    {
        return $this->cached($option_key.':'.$group, function() use ($option_key, $group) {
            return $this->model->where('key', $option_key)->whereGroup($group)->first();
        });
    }

}
