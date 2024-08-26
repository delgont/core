<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use Delgont\Core\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Cache;

use App\Entities\Clazz;
use Modules\Student\Entities\TermlyRegistration;



class ClazzRepository extends BaseRepository
{

    /**
     * Term from which to get the class data
     */
    protected $term;

     /**
     * Whether to get registrations from cache or from db
     */
    protected $fromCache = false;

    /**
     * Cache expiry time
     */
    protected $cacheExpiry = 1440;



    public function __construct(Clazz $model)
    {
        parent::__construct($model);
        $this->cachePrefix = 'Clazz';
    }



    /**
     * Get current term clazz info
     */
    public function current()
    {
        $this->term = term();
        return $this;
    }

    public function getRegistrations()
    {
        $term = $this->term;
        return $this->model->with(['termlyRegistrations' => function($termlyRegistrationsQuery) use ($term){
            $termlyRegistrationsQuery->whereHas('term', function($termQuery) use ($term){
                $termQuery->whereId($term->id);
            });
        }])->get();
    }

    public function getTotalRegistrationsPerClazz()
    {
        $term = $this->term;
        return $this->cached($this->getCachePrefix().':Current:Total:Registrations:Per:Clazz', function() use ($term){
            return $this->model->withCount(['termlyRegistrations' => function($registrationQuery) use ($term){
                $registrationQuery->whereTermId($term->id);
            }])->get()->mapWithKeys(function($item){
                return [($item['abbr']) ? $item['abbr'] : $item['name'] => $item['termly_registrations_count']];
            })->toArray();;
        });
    }


}
