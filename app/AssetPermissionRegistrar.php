<?php

namespace App;

use Delgont\Auth\PermissionRegistrar;

class AssetPermissionRegistrar extends PermissionRegistrar
{
    protected $group = 'asset management';

    const CAN_MANAGE_ASSETS = 'can_manage_assets';
    const CAN_VIEW_ASSETS = 'can_view_assets';
    const CAN_ADD_ASSET = 'can_add_asset';
    const CAN_VIEW_ASSET_DETAILS = 'can_view_asset_details';
    const CAN_DELETE_ASSET = 'can_delete_asset';
    const CAN_VIEW_ASSET_FINANCE_DETAILS = 'can_view_asset_finance_details';
    const CAN_EDIT_ASSET_FINANCE_DETAILS = 'can_edit_asset_finance_details';
    const CAN_EDIT_ASSET_DETAILS = 'can_edit_asset_details';
    const CAN_CHANGE_ASSET_PHOTO = 'can_change_asset_photo';

    const CAN_VIEW_ASSET_TYPES = 'can_view_asset_types';


    public function descriptions()
    {
        return [
         self::CAN_VIEW_ASSETS => 'User will able to view asset listing...',
        ];
    }
    
}