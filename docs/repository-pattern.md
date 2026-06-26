# Repository Pattern Guide

## Purpose
The `BaseRepository` class standardizes **read operations** for Eloquent models.  
It enforces **separation of concerns**:
- **Repositories** → handle queries, retrieval, pagination, caching.  
- **Services** → handle mutations (create, update, delete).  

This keeps your architecture clean: repositories are for **data access**, services are for **business logic**.

---

## ⚙️ Key Responsibilities
- **Read only**: `all`, `get`, `paginate`, `findOrFail`, `first`, `where`.  
- **Caching**: Uses `HandlesModelCaching` trait to cache query results.  
- **Relations**: Supports eager loading (`with`) and relation counts (`withCount`).  
- **Consistency**: Cache keys are generated using the model’s class name.  

---

```php
public function index(StudentRepository $studentRepo)
{
    // Fetch all students with caching
    $students = $studentRepo->all();

    return response()->json($students);
}

public function show(StudentRepository $studentRepo, $id)
{
    try {
        $student = $studentRepo->findOrFail($id);
        return response()->json($student);
    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Student not found'], 404);
    }
}

```

```php
<?php

namespace Modules\Schoolviser\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;

use Delgont\Core\Repository\Eloquent\BaseRepository;

use Modules\Schoolviser\Entities\CourseGroup;
use Modules\Schoolviser\Cache\CacheKeys\CourseGroupCacheKeys as CacheKeys;
use App\Traits\Repositories\EnsureCompanyIsSet;

class CourseGroupRepository extends BaseRepository
{
    use EnsureCompanyIsSet;

    public function __construct(CourseGroup $model)
    {
        parent::__construct($model);
    }

    public function getCourseGroup($id)
    {
        $this->ensureCompanyIsSet();

        $cacheKey = CacheKeys::COURSE_GROUP . CacheKeys::appendCacheSuffix(false, $this->companyId,$id);

        return $this->cachedForever($cacheKey, function() use ($id){
            return $this->model::whereCompanyId($this->companyId)->where('uuid', $id)->firstOrFail();
        });
    }

    public function getPaginatedCourseGroups($perPage = 15, $page = 1, $attributes = ['*'])
    {
        $this->ensureCompanyIsSet();
        $cacheKey = CacheKeys::PAGINATED_COURSE_GROUPS . CacheKeys::appendCacheSuffix(true, $this->companyId) . CacheKeys::appendPaginationCacheSuffix($perPage, $page);

        return $this->cached($cacheKey, function() use ($perPage, $page, $attributes){
            return $this->model::whereCompanyId($this->companyId)->paginate($perPage, $attributes, 'page', $page);
        });

    }


   
}
```

## Key Takeaways

- Repositories are read-only: they never mutate data.
- Services handle mutations: use ModelService for create/update/delete.
- Caching is built-in: queries are cached for performance.
- Extend repositories: add domain-specific queries (e.g. activeStudents).

> This pattern ensures a clean separation between data access and business logic, making your codebase easier to maintain and scale.

