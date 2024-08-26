<?php

namespace App;

use Delgont\Auth\PermissionRegistrar;

class LibraryPermissionRegistrar extends PermissionRegistrar
{
    protected $group = 'the library';

    const CAN_MANAGE_LIBRARY = 'can_manage_library';
    const CAN_VIEW_LIBRARY_BOOKS = 'can_view_libary_books';

    public function descriptions()
    {
        return [
         self::CAN_MANAGE_LIBRARY => 'User will be able to manage the library ....!'
        ];
    }
    
}