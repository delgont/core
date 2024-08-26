<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

use App\Models\Employee\Employee;

class EmployeePosition extends Model
{
    protected $fillable = ['name', 'description'];

     /**
     * Get staff members
     */
    public function members()
    {
        return $this->hasMany(Employee::class, 'employee_position_id');
    }

}
