<?php

use Delgont\Core\Repository\OptionRepository;

if(!function_exists('option')){
    function option($option_key, $group, $default = null){
        return app(OptionRepository::class)->fromCache()->findOption($option_key, $group)->value ??  $default;
    }
}
