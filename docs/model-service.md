# ModelService Guide

## Purpose
The `ModelService` abstract class standardizes **mutation logic** (`create`, `update`, `delete`) for Eloquent models.  
It enforces **separation of concerns**:
- **Repositories** → fetch data from the database.  
- **Services** → mutate data only.  

This ensures clean architecture and predictable workflows.

---

## Lifecycle Hooks
`ModelService` provides chainable lifecycle hooks for mutation events:

- `beforeCreate` / `afterCreate`
- `beforeUpdate` / `afterUpdate`
- `beforeDelete` / `afterDelete`
- `onFailure`

Callbacks are **chainable**:

```php
$studentService
    ->before('update', function ($student, $data) {
        if ($student->status === 'archived') {
            throw ValidationException::withMessages([
                'student' => ['Archived students cannot be updated.'],
            ]);
        }
        return $data;
    })
    ->before('delete', function ($student) {
        if ($student->is_protected) {
            throw ValidationException::withMessages([
                'student' => ["Student {$student->id} is protected and cannot be deleted."],
            ]);
        }
    })->update($student, $data);

    $studentService
    ->before('delete', function ($student) {
        if ($student->is_protected) {
            throw ValidationException::withMessages([
                'student' => ["Student {$student->id} is protected and cannot be deleted."],
            ]);
        }
    })->delete($student);
```


## Example: StudentService Implementation

```php
<?php

namespace Modules\Schoolviser\Services;

use Delgont\Core\Services\ModelService;
use Modules\Schoolviser\Entities\Student;
use Modules\Schoolviser\Entities\CourseGroup;
use Modules\Schoolviser\Cache\CacheKeys\StudentCacheKeys;
use Illuminate\Validation\ValidationException;

class StudentService extends ModelService
{
    public function __construct(Student $student){
        parent::__construct($model);
    }

    public function addStudentToCourseGroup(Student $student, CourseGroup $group): Student
    {
        $this->run('before', 'addStudentToCourseGroup', $student, $group);

        $student->course_group_id = $group->id;
        $student->save();

        $this->run('after', 'addStudentToCourseGroup', $student, $group);
        $this->afterMutation($student);

        return $student;
    }
}


```

## Example Usage in Controller

```php

use Modules\Schoolviser\Services\StudentService;
use Modules\Schoolviser\Repositories\StudentRepository;
use Modules\Schoolviser\Repositories\CourseGroupRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    public function __construct(
        protected StudentService $studentService,
        protected StudentRepository $studentRepo,
        protected CourseGroupRepository $groupRepo
    ) {}

    public function assignToGroup(Request $request)
    {
        $student = $this->studentRepo->findById($request->student_id);
        $courseGroup = $this->groupRepo->findById($request->course_group_id);

        // Attach validation logic via generic before hook
        $this->studentService
            ->before('addStudentToCourseGroup', function ($student, $courseGroup) {
                if ($student->status !== 'active') {
                    throw ValidationException::withMessages([
                        'student' => ['Only active students can be added to a course group.'],
                    ]);
                }
            })
            ->after('addStudentToCourseGroup', function ($student, $courseGroup) {
                logger("Student {$student->id} successfully added to course group {$courseGroup->id}");
            });

        try {
            $this->studentService->addStudentToCourseGroup($student, $courseGroup);
            return response()->json(['message' => 'Student added successfully']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
```

---

### Key Takeaways
- Repositories fetch, services mutate.

- Lifecycle hooks (beforeX, afterX) are chainable.

- You can define custom domain hooks for special workflows.

- Throwing ValidationException inside callbacks integrates seamlessly with Laravel’s error handling.

> This pattern keeps your services clean, extensible, and developer‑friendly.