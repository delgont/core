<?php
/**
 * The repository deals only with Read Operations
 * 
 * For Create, Update & Delete Use Delgont\Core\Cud\BaseCud
 */
namespace Delgont\Core\Repository\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;

use Delgont\Core\Cache\HandlesModelCaching;

class BaseRepository implements EloquentRepositoryInterface
{
    use HandlesModelCaching;

     /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [];

    /**
     * The relationship counts that should be eager loaded on every query.
     *
     * @var array
     */

    protected $withCount = [];



    /**
     * BaseRepository constructor.
     *
     * @param \Illuminate\Database\Eloquent\Mode $model
     */
    public function __construct( Model $model )
    {
        $this->model = $model;
        $this->cachePrefix = get_class($this->model);
    }

    public function with($with)
    {
        $this->with = (count($this->with) > 0) ?  array_merge($this->with, $with) : $with;
        return $this->model->with($with);
    }


    public function withCount($withCount)
    {
        $this->withCount = (count($this->withCount) > 0) ?  array_merge($this->withCount, $withCount) : $withCount;
        return $this;
    }

   
     /**
     * Get all model data
     * @param mixed $attributes
     * @param array $attributes
     * @param array $relations
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function all( array $attributes = ['*'] ) : Collection
    {
        if ($this->fromCache) {
            $cached = Cache::get( $this->getCachePrefix().':all' );
            if($cached){
                return $cached;
            }else{
                $all = $this->model->with($this->with)->withCount($this->withCount)->get($attributes);
                ($all) ? $this->storeCollectionInCache( $all, $this->getCachePrefix().':all' ) : '';
                return $all;
            }
        }
        return $this->model->with($this->with)->withCount($this->withCount)->get($attributes);
    }

    /**
     * Get paginated model data
     * @param int $perPage
     * @param int $offset
     * @param array $attributes
     * @param array $relations
     * 
     * @return  Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate( $perPage = 15, $offset = 1, array $attributes = ['*'] ) : LengthAwarePaginator
    {
        if ($this->fromCache) {
            $cached = Cache::get( $this->getCachePrefix().':offset:'.$offset );
            if ($cached) {
                return $cached;
            } else {
                $collection = $this->model->with($this->with)->withCount($this->withCount)->paginate($perPage);
                $this->storeLengthAwarePaginatorInCache( $collection, $this->getCachePrefix().':offset:'.$offset );
                return $collection;
            }
            
        } 
        return $this->model->with($this->with)->withCount($this->withCount)->paginate( $perPage );
    }


     /**
     * Get model by specified key or fail
     * @param mixed $attribute
     * @param array $attributes
     * @param array $relations
     * 
     * @return Illuminate\Database\Eloquent\Model
     */
    public function findOrFail($id, array $attributes = ['*'])
    {
        if($this->fromCache){
            $cached = $this->getModelFromCache( $this->getCachePrefix().':'.$id );
            if( $cached ) {
                return $cached;
            }else{
                $model = $this->model->with($this->with)->withCount($this->withCount)->findOrFail($id);
                ($model) ? $this->storeModelInCache($model, $attribute) : '';
                return $model;
            }
        }
        if($this->remember){
            $model = $this->model->with($this->with)->withCount($this->withCount)->findOrFail($id);
            $this->storeModelInCache($model);
            return $model;
        }
        return $this->model->with($this->with)->withCount($this->withCount)->findOrFail($id);
    }

    public function first()
    {
        return $this->model->first();
    }



    public function get( array $attributes = ['*'] )
    {
        return $this->all($attributes);
    }

    public function where($key, $value)
    {
        return $this->model->where($key, $value);
    }



    public function destroy($id)
    {
        return $this->model::destroy($id);
    }




    public function forget($keys)
    {
        if (is_array($keys)) {
            foreach ($keys as $key) {
                Cache::pull($key);
            }
        }else{
            Cache::pull($keys);
        }
        Cache::flush();
    }
    
    

}