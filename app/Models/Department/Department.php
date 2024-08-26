<?php

namespace App\Models\Department;

use Illuminate\Database\Eloquent\Model;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeDepartment;

class Department extends Model
{
    protected $fillable = ['name', 'description'];
    //
    /**
     * Get department staff members
     */
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_department');
    }
}
