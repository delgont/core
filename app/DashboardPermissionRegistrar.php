<?php

namespace App;

use Delgont\Auth\PermissionRegistrar;

class DashboardPermissionRegistrar extends PermissionRegistrar
{
    protected $group = 'dashbard';

    const CAN_VIEW_TOTAL_NUMBER_STUDENTS = 'can_view_total_number_of_students';
    const CAN_VIEW_TOTAL_NUMBER_OF_STAFF = 'can_view_total_number_of_staff';
    const CAN_VIEW_TOTAL_NUMBER_OF_USERS = 'can_view_total_number_of_users';
    const CAN_VIEW_GRAPHICAL_REPRESENTATION_OF_STUDENTS_PER_CLASS = 'can_view_graphical_representation_of_students_per_class';

    public function descriptions()
    {
        return [
         self::CAN_VIEW_TOTAL_NUMBER_STUDENTS => 'User will be able to view total number of students in the dashboard',
         self::CAN_VIEW_TOTAL_NUMBER_OF_STAFF => 'User will be able to view total number of staff in the dashboard',
         self::CAN_VIEW_TOTAL_NUMBER_OF_USERS => 'User will be able to view total number of users',
         self::CAN_VIEW_GRAPHICAL_REPRESENTATION_OF_STUDENTS_PER_CLASS => 'User will be able to view graphical representaion of students per class',
        ];
    }
    
}