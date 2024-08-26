<?php

namespace App;

use Delgont\Auth\PermissionRegistrar;

class UserPermissionRegistrar extends PermissionRegistrar
{
    protected $group = 'users management';

    const CAN_MANAGE_USERS = 'can_create_user_accounts';
    const CAN_VIEW_USER_LISTING = 'can_view_user_listing';
    const CAN_BLOCK_USER = 'can_block_user';

    public function descriptions()
    {
        return [
         self::CAN_VIEW_USER_LISTING => 'User with this right will be able to view a listing of user accounts. He may not be able to view individual user accounts unless give that right',
        ];
    }
    
}