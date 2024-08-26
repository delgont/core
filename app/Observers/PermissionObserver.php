<?php

namespace App\Observers;

use Delgont\Auth\Models\Permission;
use Delgont\Auth\Models\Role;


class PermissionObserver
{
    /**
     * Handle the permission "created" event.
     *
     * @param  \App\Delgont\Auth\Models\Permission  $permission
     * @return void
     */
    public function created(Permission $permission)
    {
        $role = Role::firstOrCreate(['name' => 'master'], ['name' => 'master']);

        $permissions = Permission::all();
        $role->givePermissionTo($permissions);
    }

    /**
     * Handle the permission "updated" event.
     *
     * @param  \App\Delgont\Auth\Models\Permission  $permission
     * @return void
     */
    public function updated(Permission $permission)
    {
        //
        $role = Role::firstOrCreate(['name' => 'master'], ['name' => 'master']);
        $permissions = Permission::all();

        $role->givePermissionTo($permissions);
    }

    /**
     * Handle the permission "deleted" event.
     *
     * @param  \App\Delgont\Auth\Models\Permission  $permission
     * @return void
     */
    public function deleted(Permission $permission)
    {
        //
    }

    /**
     * Handle the permission "restored" event.
     *
     * @param  \App\Delgont\Auth\Models\Permission  $permission
     * @return void
     */
    public function restored(Permission $permission)
    {
        //
    }

    /**
     * Handle the permission "force deleted" event.
     *
     * @param  \App\Delgont\Auth\Models\Permission  $permission
     * @return void
     */
    public function forceDeleted(Permission $permission)
    {
        //
    }
}
