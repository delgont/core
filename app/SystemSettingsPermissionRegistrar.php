<?php

namespace App;

use Delgont\Auth\PermissionRegistrar;

class SystemSettingsPermissionRegistrar extends PermissionRegistrar
{
    protected $group = 'system settings';

    const CAN_VIEW_SYSTEM_SETTINGS = 'can_view_system_settings';

    public function descriptions()
    {
        return [
         self::CAN_VIEW_SYSTEM_SETTINGS => 'User will able to view asset listing...',
        ];
    }
    
}