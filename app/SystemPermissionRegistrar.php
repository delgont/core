<?php

namespace App;

use Delgont\Auth\PermissionRegistrar;

class SystemPermissionRegistrar extends PermissionRegistrar
{
    protected $group = 'asset management';

    const CAN_MANAGE_SYSTEM_PERMISSIONS = 'can_manage_system_permissions';
    const CAN_MANAGE_USER_ROLES = 'can_manage_user_roles';

    public function descriptions()
    {
        return [
         self::CAN_MANAGE_SYSTEM_PERMISSIONS => 'User will able to view asset listing...',
        ];
    }
    
}