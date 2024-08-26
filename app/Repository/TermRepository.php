<?php
namespace App\Repository;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

use Delgont\Core\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Cache;


use App\Entities\Term;
use App\Cache\TermCacheKeys;

use Delgont\Core\Entities\Any;


class TermRepository extends BaseRepository
{
    
    protected $term;

    protected $current = false;

    public function __construct(Term $model){
        parent::__construct($model);
        $this->cachePrefix = $this->model::$cachePrefix;
    }

    public function current()
    {
        $this->current = true;
        return $this;
    }


    public function getRegistrations()
    {
        return $this->cached(TermCacheKeys::CURRENT_TERM_REGISTRATIONS, function(){
            $term = $this->model->current()->with(['termlyRegistrations' => function($termlyRegistrationQuery){
                $termlyRegistrationQuery->with('student');
            }])->first();
            return $term->termlyRegistrations;
        });
    }


    public function getStudents()
    {
        return $this->cached(TermCacheKeys::CURRENT_TERM_STUDENTS, function(){
            return $this->getRegistrations()->map(function($item, $key){
                return $item->student;
            });
        });
    }


    public function getCurrentTerm()
    {
        return $this->cached(TermCacheKeys::CURRENT_TERM, function(){
            return $this->model::current()->first();
        });
    }

    //Get the previous term
    public function getPreviousTerm()
    {
        return $this->cached(TermCacheKeys::PREVIOUS_TERM, function(){
            return $this->model::previous()->first();
        });
    }

    //get total number of students in the term
    

    
}