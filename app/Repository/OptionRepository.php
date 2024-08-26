<?php
namespace App\Repository;


use App\Repository\Eloquent\BaseRepository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\Cache;


use App\Option;

class OptionRepository extends BaseRepository
{
    public function __construct(Option $model){
        parent::__construct($model);
    }


    /**
     * Get general settings options
     */

     public function getGeneralSettings()
     {
        if ($this->fromCache) {
            $cached = Cache::get('general_settings');
            if($cached){
                return $cached;
            }
            $data = $this->model->generalSettings()->get();
            $this->storeCollectionInCache($data, 'general_settings');
            return $data;
        }
        return $this->model->generalSettings()->get();
     }

     /**
      * Get option of specific key
      */
      public function ofKey( $key, $default = null, $identifier = null )
      {
        if ($this->fromCache) {
            $cached = Cache::get( $key );
            if ($cached) {
                $models = $this->model::hydrate([$cached]);
                return $model = $models[0] ?? $default;
            } else {
                $data = $this->model->ofKey( $key )->first();
                if ($data) {
                    # code...
                    $this->storeModelInCache( $data, $key );
                } else {
                    # code...
                    $data = $this->model::updateOrCreate(['key' => $key], ['key' => $key, 'value' => $default]);
                    $this->storeModelInCache( $data, $key );
                }
                
                return $data;
            }
        }
        return $this->model->ofKey( $key )->first();
      }
    
}