<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Models\Department\Department;

use App\Models\Employee\EmployeePosition;
use App\Models\Employee\EmployeeDepartment;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Concerns\Archivable;
use App\Concerns\Left;

use Carbon\Carbon ;

class Employee extends Model
{
    use SoftDeletes, Archivable, Left;

    protected $with = ['position'];
    protected $fillable = [
        'first_name', 'last_name', 'email', 'teacher'
    ];

    protected $appends = [
        'age', 'name'
    ];


    /**
     * Get employee full names
     */
    public function getNameAttribute()
    {
        return $this->attributes['first_name'].' '.$this->attributes['last_name'];
    }

    public function hasAccount() : bool
    {
        return ($this->user()->first()) ? true : false;
    }

    /**
     * 
     */
    public function getFullNameAttribute()
    {
       return ucwords("{$this->first_name} {$this->last_name}");
    }

    /**
     * Get only married staff memebers
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMarried($query)
    {
        return $query->whereMaritalStatus('married');
    }




    /**
     * Get only married staff memebers
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTeacher($query)
    {
        return $query->whereTeacher(1);
    }

    /**
     * Get only divorced staff memebers
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDivorced($query)
    {
        return $query->whereMaritalStatus('divorced');
    }

    /**
     * Get only male staff memebers
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMale($query)
    {
        return $query->whereGender('male');
    }

     /**
     * Get only female staff memebers
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFemale($query)
    {
        return $query->whereGender('female');
    }

    /**
     * Get the position to which the staff member belongs to
     */
    public function position()
    {
        return $this->belongsTo(EmployeePosition::class, 'employee_position_id');
    }

     /**
     * Get the departments to which the staff member belongs to
     */
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'employee_department');
    }

    /**
     * Get user account details
     */
    public function user()
    {
        return $this->morphOne(User::class, 'user');
    }

    public function getAgeAttribute()
    {
        $today = Carbon::parse(today());
        return ($this->date_of_birth) ? $today->diffInYears($this->date_of_birth) : 0;
    }
}
